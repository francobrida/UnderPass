<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'lineup', 'description', 'date', 
        'start_time', 'end_time', 'price', 'price_info', 'ticket_link',
        'location_name', 'neighborhood', 'is_verified', 'flyer', 'is_18_plus'
    ];

    public function organizer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'event_genre');
    }

    public function vibeChecks() {
        return $this->hasMany(VibeCheck::class);
    }

    public function vouches() {
        return $this->belongsToMany(User::class, 'vouches');
    }

    public function getVouchProgressAttribute()
    {
        return $this->vouches()->count();
    }

    public function stamps() {
        return $this->hasMany(Stamp::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->stamp_token = Str::random(32); /* this generates a unique random token for the event, 
             which will be used for claiming stamps */
        });
    }

}
