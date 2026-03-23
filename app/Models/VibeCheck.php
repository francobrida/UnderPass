<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;

class VibeCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 
        'user_id', 
        'sound_score', 
        'safe_space_score', 
        'comment'
    ];
}