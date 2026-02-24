<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $fillable = ['user_id', 'event_id', 'scanned_at'];
}
