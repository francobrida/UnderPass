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

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['genres', 'organizer']);

        return view('events.show', compact('event'));
    }


}
