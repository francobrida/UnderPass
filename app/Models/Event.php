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
}
