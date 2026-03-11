<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Event;                
use App\Models\Genre;              
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
   public function index()
    {
        // El admin debe ver TODOS los eventos
        $events = Event::with('genres')->latest()->get();

        // Obtenemos todos los usuarios EXCEPTO el autenticado
        $users = User::where('id', '!=', Auth::id())->latest()->get();

        return view('admin.events.index', compact('events', 'users'));
    }

}
