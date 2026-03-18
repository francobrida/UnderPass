<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\StampService;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    public function __construct(
        private StampService $stampService
    ) {}

    public function stamps()
    {
        $user = Auth::user();
        $stamps = $this->stampService->getUserStamps($user->id);

        return view('profile.stamps', compact('stamps', 'user'));
    }

    public function claim($token)
    {
        $result = $this->stampService->claimStamp(Auth::user(), $token);

        if ($result['status'] === 'already_has') {
            return redirect()->route('events.show', $result['event'])
                ->with('info', 'Ya tienes este sello.');
        }

        return redirect()->route('user.stamps')
            ->with('success', '¡Nuevo sello añadido a tu pasaporte!');
    }

    public function vibecheckForm(Event $event)
    {
        if (!$this->stampService->hasStamp(Auth::user(), $event)) {
            return redirect()->route('events.index')
                ->with('error', 'No, sorry.');
        }

        return view('events.vibecheck', compact('event'));
    }
}