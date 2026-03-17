<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\VibeCheckService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VibeCheckController extends Controller
{
    public function __construct(
        private VibeCheckService $vibecheckService
    ) {}

    public function create(Event $event)
    {
        if (!$this->vibecheckService->canUserVibeCheck(Auth::user(), $event)) {
            return redirect()->route('events.index')->with('error', 'No puedes evaluar un evento al que no asististe.');
        }

        return view('events.vibecheck', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'sound_score'      => 'required|integer|min:1|max:5',
            'safe_space_score' => 'required|integer|min:1|max:5',
            'comment'          => 'required|string|max:1000',
        ]);

        $storedSuccess = $this->vibecheckService->store(Auth::user(), $event, $validated);

        if (!$storedSuccess) {
            return redirect()->route('user.stamps')->with('info', 'Ya evaluaste este evento.');
        }

        return redirect()->route('user.stamps')->with('success', '¡VibeCheck enviado! +5 puntos ganados.');
    }
}