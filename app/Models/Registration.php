<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;
    protected $primaryKey = 'registration_id';

    protected $fillable = [
        'event_id',
        'registration_id',
        'contact_name',
        'contact_email',
        'status',
    ];

    public function event() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}
