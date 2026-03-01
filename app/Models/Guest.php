<?php

namespace App\Models;

use App\Models\Guest;
use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $primaryKey = 'guest_id';

    protected $fillable = [
        'full_name',
        'email',
        'event_id',
        'registration_id',
        'invited_by_id',
        'is_primary',
        'dietary_notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function registration(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id', 'registration_id');
    }

    public function inviter() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Guest::class, 'invited_by_id');
    }

    public function invitees() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Guest::class, 'invited_by_id');
    }

}
