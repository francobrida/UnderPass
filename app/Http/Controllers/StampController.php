<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    public function stamps()
    {
        $stamps = Stamp::where('user_id', Auth::id())
            ->with('event') 
            ->latest('scanned_at')
            ->get();

        return view('profile.stamps', compact('stamps'));
    }

    public function claim($token)
    {
        $event = Event::where('stamp_token', $token)->firstOrFail();
        $user = Auth::user();

        $alreadyHasStamp = Stamp::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyHasStamp) {
            return redirect()->route('events.show', $event)
                ->with('info', 'Ya tienes este sello.');
        }

        Stamp::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'scanned_at' => now(),
        ]);

        return redirect()->route('user.stamps') // Redirigimos a la colección para que lo vea
            ->with('success', '¡Nuevo sello añadido a tu pasaporte!');
    }

    public function vibecheckForm(Event $event)
    {
        $user = Auth::user();

        $hasStamp = \App\Models\Stamp::where('user_id', $user->id)->where('event_id', $event->id)->exists();

        if (!$hasStamp) {
            return redirect()->route('events.index')->with('error', 'No puedes evaluar un evento al que no asististe.');
        }

        return view('events.vibecheck', compact('event'));
    }
}