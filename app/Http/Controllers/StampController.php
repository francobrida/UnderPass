<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\StampService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StampController extends Controller
{
    public function __construct(
        private StampService $stampService
    ) {}

    public function stamps(): View
    {
        $user = Auth::user();
        $stamps = $this->stampService->getUserStamps($user->id);

        return view('profile.stamps', compact('stamps', 'user'));
    }

    public function claim(string $token): RedirectResponse
    {
        $result = $this->stampService->claimStamp(Auth::user(), $token);

        if ($result['status'] === 'already_has') {
            return redirect()->route('events.show', $result['event'])
                ->with('info', 'Ya tienes este sello.');
        }

        return redirect()->route('user.stamps')
            ->with('success', '¡Nuevo sello añadido a tu pasaporte!');
    }

    public function vibecheckForm(Event $event): View|RedirectResponse
    {
        if (!$this->stampService->hasStamp(Auth::user(), $event)) {
            return redirect()->route('events.index')
                ->with('error', 'No, sorry.');
        }

        return view('events.vibecheck', compact('event'));
    }
}