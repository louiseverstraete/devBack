<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'email',
        'name',
        'token',
        'sent_at',
        'registered_at',
        'expires_at',
        'note',
    ];
    
    protected $casts = [
        'sent_at' => 'datetime',
        'registered_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            if (empty($invitation->token)) {
                $invitation->token = Str::random(64);
            }
        });
    }

    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    
    public function registration(): HasOne
    {
        return $this->hasOne(Registration::class, 'invitation_id');
    }


    public function getInvitationUrlAttribute(): string
    {
        return route('event.register', [
            'event' => $this->event->slug,
            'token' => $this->token
        ]);
    }

    
    public function getStatusLabelAttribute(): string
    {
        if ($this->isExpired()) {
            return 'Expirée';
        }

        if ($this->isRegistered()) {
            return 'Inscrit';
        }

        if ($this->isSent()) {
            return 'Envoyée';
        }

        return 'En attente';
    }

    
    public function getStatusColorAttribute(): string
    {
        if ($this->isExpired()) {
            return 'danger';
        }

        if ($this->isRegistered()) {
            return 'success';
        }

        if ($this->isSent()) {
            return 'primary';
        }

        return 'secondary';
    }


    public function scopePending($query)
    {
        return $query->whereNull('sent_at');
    }

    public function scopeSent($query)
    {
        return $query->whereNotNull('sent_at')
                     ->whereNull('registered_at');
    }

    public function scopeRegistered($query)
    {
        return $query->whereNotNull('registered_at');
    }

    
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    
    public function scopeExpired($query)
    {
        return $query->whereNotNull('expires_at')
                     ->where('expires_at', '<=', now());
    }

    
    public function scopeValid($query)
    {
        return $query->whereNotNull('sent_at')
                     ->whereNull('registered_at')
                     ->notExpired();
    }

    
    public function scopeForEvent($query, Event $event)
    {
        return $query->where('event_id', $event->id);
    }

    public function markAsSent(): void
    {
        $this->update(['sent_at' => now()]);
    }

    
    public function markAsRegistered(): void
    {
        $this->update(['registered_at' => now()]);
    }

    
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }

        return $this->expires_at->isPast();
    }

   
    public function isValid(): bool
    {
        return $this->isSent() 
            && !$this->isRegistered() 
            && !$this->isExpired();
    }

    
    public function isSent(): bool
    {
        return !is_null($this->sent_at);
    }

    
    public function isRegistered(): bool
    {
        return !is_null($this->registered_at);
    }

    
    public function isPending(): bool
    {
        return is_null($this->sent_at);
    }

    public function daysUntilExpiration(): ?int
    {
        if (!$this->expires_at) {
            return null;
        }

        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInDays($this->expires_at);
    }

    public function send(): void
    {
        
        $this->markAsSent();
    }

    public function setExpirationDaysBeforeEvent(int $days): void
    {
        $expirationDate = $this->event->event_date->copy()->subDays($days);
        
        $this->update(['expires_at' => $expirationDate]);
    }
}