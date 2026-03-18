<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Stamp;
use Illuminate\Support\Facades\Auth;

class StampService
{
    public function getUserStamps($userId)
    {
        return Stamp::where('user_id', $userId)
            ->with('event')
            ->latest('scanned_at')
            ->get();
    }

    public function claimStamp($user, $token)
    {
        $event = Event::where('stamp_token', $token)->firstOrFail();

        $alreadyHasStamp = Stamp::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyHasStamp) {
            return ['status' => 'already_has', 'event' => $event];
        }

        $stamp = Stamp::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'scanned_at' => now(),
        ]);

        return ['status' => 'success', 'stamp' => $stamp];
    }

    public function hasStamp($user, $event)
    {
        return Stamp::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();
    }
}