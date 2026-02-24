<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VibeCheck extends Model
{
    protected $fillable = [
    'event_id', 'user_id', 'sound_score', 'safe_space_score', 'comment'
    ];
}
