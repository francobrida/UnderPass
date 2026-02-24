<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
   protected $fillable = [
    'user_id', 'title', 'lineup', 'description', 'date', 
    'start_time', 'end_time', 'price', 'price_info', 
    'location_name', 'neighborhood', 'is_verified', 'is_18_plus'
    ];

    // An event belongs to a user (organizer)
    public function organizer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // An event can have many genres
    public function genres() {
        return $this->belongsToMany(Genre::class, 'event_genre');
    }

    public function vibeChecks() {
        return $this->hasMany(VibeCheck::class);
    }

    public function vouches() {
        return $this->belongsToMany(User::class, 'vouches');
    }

    public function stamps() {
        return $this->hasMany(Stamp::class);
    }

}
