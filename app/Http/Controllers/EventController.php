<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Services\EventService;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ){}

   public function index(Request $request)
    {
        $genres = Genre::all();
        $events = $this->eventService->filter($request->all());
        
        return view('events.index', compact('events', 'genres'));
    }

    public function show(Event $event)
    {
        $event->load(['genres', 'organizer']);
        return view('events.show', compact('event')); 
    }

    public function myEvents(Request $request)
    {
        $user = $request->user();
   
        $events = $user->events()->latest()->get();

        return view('events.my', compact('events'));
    }

    public function create()
    {
        $genres = \App\Models\Genre::all();
        return view('events.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:100',
            'lineup'        => 'required|string',
            'description'   => 'required|string',
            'date'          => 'required|date|after_or_equal:today', 
            'start_time'    => 'required',
            'end_time'      => 'required',
            'price'         => 'required|numeric|min:0',
            'price_info'    => 'nullable|string|max:100', 
            'ticket_link'   => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer'         => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'neighborhood'  => 'required|string|max:100',
            'genres'        => 'required|array|min:1', 
            'genres.*'      => 'exists:genres,id',
        ]);

        $this->eventService->store($request->user(), $validated, $request->file('flyer'));

        return redirect()->route('events.my')->with('success', 'Evento creado. Esperando verificaciones!');
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id() && Auth::user()->role->value !== 'admin') {
            abort(403, 'No tienes permiso para editar este evento.');
        }

        $genres = Genre::all();
        
        return view('events.edit', compact('event', 'genres'));
    }

    public function update(Request $request, Event $event) 
    {
        
        if ($event->user_id !== Auth::id() && Auth::user()->role->value !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'title'         => 'required|string|max:100',
            'lineup'        => 'required|string',
            'description'   => 'required|string',
            'date'          => 'required|date', 
            'start_time'    => 'required',
            'end_time'      => 'required',
            'price'         => 'required|numeric|min:0',
            'price_info'    => 'nullable|string|max:100', 
            'ticket_link'   => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
            'neighborhood'  => 'required|string|max:100',
            'genres'        => 'required|array|min:1', 
            'genres.*'      => 'exists:genres,id',
        ]);

        if (Auth::user()->role->value === 'admin') {
            $event->is_verified = $request->has('is_verified');
        }

        $this->eventService->update($event, $validated, $request->file('flyer'));

        return redirect()->route('events.my')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Request $request, Event $event) 
    {
        if ($request->user()->id !== $event->user_id && $request->user()->role->value !== 'admin') {
            abort(403);
        }

        $this->eventService->delete($event);

        return back()->with('success', 'Evento eliminado.');
    }

    public function vouch(Event $event)
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
    
    public function waitingRoom()
    {
        $events = Event::where('is_verified', false)->withCount('vouches')->latest()->get();

        return view('events.waiting-room', compact('events'));
    }

    public function feedback(Event $event)
    {
        if (Auth::id() !== $event->user_id) {
            abort(403);
        }

        $event->load('vibeChecks');

        return view('admin.events.feedback', compact('event'));
    }
}
