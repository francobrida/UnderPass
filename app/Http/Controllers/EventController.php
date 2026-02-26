<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        return view('events.index', compact('events')); // compact sends $events to the view.
    }

    public function show(Event $event)
    {
        $event->load(['genres', 'organizer']);

        return view('events.show', compact('event')); 
    }

    public function myEvents(Request $request)
    {
        // Usamos $request->user(), que es lo mismo pero el editor lo entiende mejor
        $user = $request->user();

        // Si por algún milagro llegara aquí sin estar logueado, evitamos el crash
        if (!$user) {
            return redirect()->route('login');
        }
        // 2. Usamos la relación events() que creamos en el modelo User.
        // Esto hace un "SELECT * FROM events WHERE user_id = id_del_usuario"
        // latest() para que sus creaciones más recientes salgan primero.
        $events = $user->events()->latest()->get();

        return view('events.my', compact('events'));
    }

    public function create()
    {
        // Obtenemos todos los géneros de la base de datos (id y name)
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
            'price_info' => 'nullable|string|max:100', 
            'ticket_link' => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'neighborhood'  => 'required|string|max:100',
            'genres' => 'required|array|min:1', // Al menos un género seleccionado
            'genres.*' => 'exists:genres,id',    // Verifica que el ID existe en la tabla genres
        ]);

        if (empty($validated['price_info'])) {
            $validated['price_info'] = $validated['price'] == 0 ? 'Entrada gratuita' : '';
        }

        // Gestión de la imagen
        if ($request->hasFile('flyer')) {
            $path = $request->file('flyer')->store('flyers', 'public');
            $validated['flyer_path'] = $path;
        }

        $event = $request->user()->events()->create($validated);
        // Sincronizamos con la tabla intermedia 'event_genre'
        $event->genres()->attach($request->genres);

        return redirect()->route('events.my')->with('success', 'Evento creado. Esperando verificaciones! 0/3');

    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event); // verifies if the user can update the event, otherwise throws a 403 error. necessary?
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event) 
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)->with('success', 'Evento actualizado.');
    }

    public function delete(Event $event)
    {
        $this->authorize('delete', $event); // verifies if the user can delete the event, otherwise throws a 403 error.
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Evento eliminado.');
    }

}
