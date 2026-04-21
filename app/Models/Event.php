<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'lineup', 'description', 'date', 
        'start_time', 'end_time', 'price', 'price_info', 'ticket_link',
        'location_name', 'neighborhood', 'is_verified', 'flyer', 'is_18_plus'
    ];

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'event_genre');
    }

    public function vibeChecks(): HasMany
    {
        return $this->hasMany(VibeCheck::class);
    }

    public function vouches(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vouches');
    }

    public function getVouchProgressAttribute(): int
    {
        return $this->vouches()->count();
    }

    public function stamps(): HasMany
    {
        return $this->hasMany(Stamp::class);
    }
}