<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\VibeCheckService;
use App\Http\Requests\StoreVibeCheckRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VibeCheckController extends Controller
{
    public function __construct(
        private VibeCheckService $vibecheckService
    ) {}

    public function create(Event $event): View|RedirectResponse
    {
        if (!$this->vibecheckService->canUserVibeCheck(Auth::user(), $event)) {
            return redirect()->route('events.index')->with('error', 'No puedes evaluar un evento al que no asististe.');
        }

        return view('events.vibecheck', compact('event'));
    }

    public function store(StoreVibeCheckRequest $request, Event $event): RedirectResponse
    {
        $storedSuccess = $this->vibecheckService->store(
            Auth::user(), 
            $event, 
            $request->validated()
        );

        if (!$storedSuccess) {
            return redirect()->route('user.stamps')->with('info', 'Ya evaluaste este evento.');
        }

        return redirect()->route('user.stamps')->with('success', '¡VibeCheck enviado! +5 puntos ganados.');
    }
}