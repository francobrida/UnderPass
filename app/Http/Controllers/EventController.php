<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ){}

   public function index(Request $request): View
    {
        $genres = Genre::all();
        $events = $this->eventService->filter($request->all());
        
        return view('events.index', compact('events', 'genres'));
    }

    public function show(Event $event): View
    {
        $event->load(['genres', 'organizer']);
        return view('events.show', compact('event')); 
    }

    public function myEvents(): View
    {
        $user = Auth::user();
        $currentTime = now(); 

        $nextEvents = $user->events()
            ->where('date', '>=', $currentTime->toDateString())
            ->orderBy('date', 'asc')
            ->get();

        $pastEvents = $user->events()
            ->where('date', '<', $currentTime->toDateString())
            ->orderBy('date', 'desc')
            ->get();

        return view('events.my', compact('nextEvents', 'pastEvents'));
    }

    public function create(): View
    {
        $genres = \App\Models\Genre::all();
        return view('events.create', compact('genres'));
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->eventService->store(
            $request->user(), 
            $request->validated(), 
            $request->file('flyer')
        );

        return redirect()->route('events.my')->with('success', 'Evento creado. Esperando verificaciones!');
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        if (Auth::user()->role->value === 'admin') {
            $event->is_verified = $request->has('is_verified');
        }

        $this->eventService->update($event, $request->validated(), $request->file('flyer'));

        return redirect()->route('events.my')->with('success', 'Evento actualizado correctamente.');
    }

    public function edit(Event $event): View
    {
        if ($event->user_id !== Auth::id() && Auth::user()->role->value !== 'admin') {
            abort(403, 'No tienes permiso para editar este evento.');
        }

        $genres = Genre::all();
        
        return view('events.edit', compact('event', 'genres'));
    }

    public function destroy(Request $request, Event $event): RedirectResponse
    {
        if ($request->user()->id !== $event->user_id && $request->user()->role->value !== 'admin') {
            abort(403);
        }

        $this->eventService->delete($event);

        return back()->with('success', 'Evento eliminado.');
    }

    public function vouch(Event $event): RedirectResponse
    {
        $user = Auth::user();
        $event->load('organizer'); 

        if ($event->user_id === $user->id) {
            return back()->with('error', 'No puedes votar tu propio evento.');
        }

        if ($event->vouches()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Ya has dado tu fe por este evento.');
        }

        $isVerified = $this->eventService->vouch($event, $user);

        if ($isVerified) {
            return redirect()->route('events.index')->with('success', '¡Evento verificado! Ahora es visible.');
        }

        return back()->with('success', 'Voto registrado.');
    }
    
    public function waitingRoom(): View
    {
        $events = Event::where('is_verified', false)->withCount('vouches')->latest()->get();

        return view('events.waiting-room', compact('events'));
    }

    public function feedback(Event $event): View
    {
        if (Auth::id() !== $event->user_id) {
            abort(403);
        }

        $event->load('vibeChecks');

        return view('admin.events.feedback', compact('event'));
    }
}