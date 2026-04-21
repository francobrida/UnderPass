<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Stamp;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class StampService
{
    public function getUserStamps(int $userId): Collection
    {
        return Stamp::where('user_id', $userId)
            ->with('event')
            ->latest('scanned_at')
            ->get();
    }

    public function claimStamp(User $user, string $token): array
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

    public function hasStamp(User $user, Event $event): bool
    {
        return Stamp::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();
    }
}