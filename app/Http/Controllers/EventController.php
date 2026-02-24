<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Traemos todos los eventos de la base de datos
        $events = Event::all();

        // Los enviamos a una vista llamada 'events.index'
        return view('events.index', compact('events'));
    }
}
