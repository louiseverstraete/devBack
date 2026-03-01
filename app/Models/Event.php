<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Invitation;

class Event extends Model
{
    use HasFactory;
    protected $primaryKey = 'event_id';
    public $incrementing = true;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'event_date',
        'location',
        'image_url',
        'visibility',
        'max_capacity',
        'status',
    ];

    public function invitations()
{
    return $this->hasMany(Invitation::class, 'event_id', 'event_id');
}


    public function user() {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function IsPublic() {
        return $this->visibility === 'PUBLIC';
    }
}
