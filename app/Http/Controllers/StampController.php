<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    /**
     * Muestra la colección de sellos del usuario.
     */
    public function stamps()
    {
        $stamps = Stamp::where('user_id', Auth::id())
            ->with('event') // Carga el evento para evitar consultas extra (Eager Loading)
            ->latest('scanned_at')
            ->get();

        return view('profile.stamps', compact('stamps'));
    }

    /**
     * Lógica para reclamar un sello (la que hicimos antes).
     */
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
        // 1. Validar que el usuario tenga el stamp de este evento
        $hasStamp = \App\Models\Stamp::where('user_id', $user->id())
                    ->where('event_id', $event->id)
                    ->exists();

        if (!$hasStamp) {
            return redirect()->route('events.index')->with('error', 'No puedes evaluar un evento al que no asististe.');
        }

        return view('event.vibecheck', compact('event'));
    }
}