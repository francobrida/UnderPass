<?php

namespace App\Services;

use App\Models\VibeCheck;
use App\Models\Stamp;
use Illuminate\Support\Facades\DB;

class VibeCheckService 
{
    public const int POINTS_FOR_VIBECHECK = 5;

    public function canUserVibeCheck($user, $event): bool
    {
        return Stamp::where('user_id', $user->id)->where('event_id', $event->id)->exists();
    }

    public function store($user, $event, array $data)
    {
        $alreadyVoted = VibeCheck::where('user_id', $user->id)->where('event_id', $event->id)->exists();

        if ($alreadyVoted) {
            return false;
        }

        VibeCheck::create([
            'event_id'         => $event->id,
            'user_id'          => $user->id,
            'sound_score'      => $data['sound_score'],
            'safe_space_score' => $data['safe_space_score'],
            'comment'          => $data['comment'],
        ]);

        $user->increment('points', self::POINTS_FOR_VIBECHECK);

        return true;
    }
}