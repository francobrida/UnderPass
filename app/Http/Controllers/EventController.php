<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public const int VOUCHES_TO_VERIFY = 3;

    public function index(Request $request)
    {
        $genres = \App\Models\Genre::all();

        // 1. Iniciamos la consulta: verificados Y que no hayan pasado de fecha
        $query = Event::with('genres')
            ->where('is_verified', true)
            ->where('date', '>=', now()->toDateString()); // <--- ESTO: Solo hoy o futuro

        // 2. Filtro por nombre o lineup
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('lineup', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Filtro por Barrio
        if ($request->filled('neighborhood')) {
            $query->where('neighborhood', $request->neighborhood);
        }

        // 4. Filtro por Estilo (Género)
        if ($request->filled('genre')) {
            $query->whereHas('genres', function($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        // 5. Ordenar por Precio
        if ($request->price === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->price === 'desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('date', 'asc');
        }

        $events = $query->get();

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

        if (!$user) {
            return redirect()->route('login');
        }
   
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
            'price_info' => 'nullable|string|max:100', 
            'ticket_link' => 'nullable|url',
            'location_name' => 'required|string|max:100',
            'flyer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'neighborhood'  => 'required|string|max:100',
            'genres' => 'required|array|min:1', 
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
        // --- SEGURIDAD MANUAL ---
        // Verificamos si el usuario logueado es el dueño del evento
        if ($event->user_id !== Auth::id() && Auth::user()->role->value !== 'admin') {
            abort(403, 'No tienes permiso para editar este evento.');
        }
        // ------------------------

        $genres = Genre::all();
        
        return view('events.edit', compact('event', 'genres'));
    }

    public function update(Request $request, Event $event) 
    {
        // --- SEGURIDAD MANUAL ---
        // Verificamos si el usuario logueado es el dueño antes de actualizar
        if ($event->user_id !== Auth::id() && $request->user()->role->value !== 'admin') {
            abort(403, 'No tienes permiso para actualizar este evento.');
        }
        // ------------------------

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
            'is_verified' => 'nullable|boolean'
        ]);

        if ($request->user()->role->value === 'admin') {
            $validated['is_verified'] = $request->has('is_verified');
        }

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

        return redirect()->route('events.my')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Request $request, Event $event) 
    {

        if ($request->user()->id !== $event->user_id && $request->user()->role->value !== 'admin') {
            abort(403, 'No tienes permiso para borrar este evento.');
        }

        if ($event->flyer) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($event->flyer);
        }

        $event->delete();

        return redirect()->route('events.my')->with('success', 'Evento eliminado.');
    }
    /*
    public function adminIndex()
    {
        $user = Auth::user();

        if ($user->role->value !== 'admin') {
            return redirect('/')->with('error', 'No tienes permiso de admin');
        }

        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }
    */
    public function waitingRoom()
    {
        $events = Event::where('is_verified', false) 
            ->withCount('vouches')
            ->latest()
            ->get();

        return view('events.waiting-room', compact('events'));
    }

    public function vouch(Event $event)
    {
        $user = Auth::user();

        if ($event->user_id === $user->id) {
            return back()->with('error', 'No puedes votar tu propio evento.');
        }

        if ($event->vouches()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Ya has dado tu fe por este evento.');
        }

        // Register the vouch
        $event->vouches()->attach($user->id);

        // Verification
        if ($event->vouches()->count() >= self::VOUCHES_TO_VERIFY) {
            $event->update(['is_verified' => true]);

            if ($event->user->role->value === 'clubber') {
                $event->user->role = 'organizer';
                $event->user->save(); // Saves in the DB
            }

            return redirect()->route('events.index')
                ->with('success', '¡Evento verificado! Ahora es visible para todos.');
        }

        return back()->with('success', 'Voto registrado.');
    }

}
