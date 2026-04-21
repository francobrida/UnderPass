<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Event;                              
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
   public function index() : View
    {
        $events = Event::with('genres')->latest()->get();

        $users = User::where('id', '!=', Auth::id())->latest()->get(); 

        return view('admin.events.index', compact('events', 'users'));
    }

}
