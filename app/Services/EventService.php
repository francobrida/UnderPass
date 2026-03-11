<?php

namespace App\Services;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class EventService {

    public function filterEvents(Request $request) {

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
        return $events;
    }

}