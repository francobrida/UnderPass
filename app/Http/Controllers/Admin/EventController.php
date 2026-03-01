<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Genre;

class EventController extends Controller
{
    public function index()
    {
        // Solo traemos los eventos donde 'is_verified' sea true (o 1)
        $events = Event::with('genres')->where('is_verified', true) ->latest()->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['genres', 'organizer']);

        return view('events.show', compact('event')); 
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
            $validated['flyer'] = $path;
        }

        $event = $request->user()->events()->create($validated);
        // Sincronizamos con la tabla intermedia 'event_genre'
        $event->genres()->attach($request->genres);

        return redirect()->route('events.my')->with('success', 'Evento creado. Esperando verificaciones! 0/3');

    }

    public function edit(Event $event)
    {
        $genres = Genre::all();
        
        return view('events.edit', compact('event', 'genres'));
    }

    public function update(Request $request, Event $event) 
    {

        // 1. Validar todos los campos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'flyer' => 'nullable|image|max:2048', 
            'lineup' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location_name' => 'required|string',
            'neighborhood' => 'required|string',
            'price' => 'numeric',
            'price_info' => 'nullable|string',
            'ticket_link' => 'nullable|url',
        ]);

        // 2. Gestión de la imagen (Flyer)
        if ($request->hasFile('flyer')) {
            // Borrar el archivo viejo si existe
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }
            // Guardar el archivo nuevo
            $validated['flyer'] = $request->file('flyer')->store('flyers', 'public');
        }

        // 3. Actualizar los datos del evento
        $event->update($validated);

        // 4. Sincronizar géneros (tabla intermedia)
        $event->genres()->sync($request->genres);

        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado por el administrador.');
    }

    public function destroy(Event $event) 
    {

        if ($event->flyer_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->flyer_path);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado por el administrador.');
    }


}
