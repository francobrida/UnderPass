<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\VibeCheck;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VibeCheckController extends Controller
{
    public const int POINTS_FOR_VIBECHECK = 5;

    public function create(Event $event)
    {
        $user = Auth::user();

        $hasStamp = Stamp::where('user_id', $user->id)->where('event_id', $event->id)->exists();

        if (!$hasStamp) {
            return redirect()->route('events.index')->with('error', 'No puedes evaluar un evento al que no asististe.');
        }

        return view('events.vibecheck', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'sound_score' => 'required|integer|min:1|max:5',
            'safe_space_score' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Avoid duplicates
        $alreadyVoted = VibeCheck::where('user_id', Auth::id())->where('event_id', $event->id)->exists();

        if ($alreadyVoted) {
            return redirect()->route('user.stamps')->with('info', 'Ya evaluaste este evento.');
        }

        VibeCheck::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'sound_score' => $request->sound_score,
            'safe_space_score' => $request->safe_space_score,
            'comment' => $request->comment,
        ]);

        Auth::user()->increment('points', self::POINTS_FOR_VIBECHECK);

        return redirect()->route('user.stamps')->with('success', '¡VibeCheck enviado! +5 puntos ganados.');
    }
}