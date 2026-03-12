<?php

namespace App\Services;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;


class EventService {

    public const int VOUCHES_TO_VERIFY = 3;

    public function filter(Request $request) {

        $query = Event::with('genres')
            ->where('is_verified', true)
            ->where('date', '>=', now()->toDateString()); // only future events

        // Filter by name or lineup
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('lineup', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by neighborhood
        if ($request->filled('neighborhood')) {
            $query->where('neighborhood', $request->neighborhood);
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        // Order by price
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

    public function processFlyer(Event $event, Request $request) {

        if ($request->hasFile('flyer')) {
            
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }

            return $request->file('flyer')->store('flyers', 'public');
        }
    }

    public function processPriceInfo(array $validated) {

        if (empty($validated['price_info'])) {
            return $validated['price'] == 0 ? 'Entrada gratuita' : '';
        }

    }

    public function verifyEvent(Event $event) : bool {

        if ($event->vouches()->count() >= self::VOUCHES_TO_VERIFY) {
            $event->update(['is_verified' => true]);

            $eventOwner = $event->organizer; 

            if ($eventOwner && $eventOwner->role->value === 'clubber') {
                
                $eventOwner->update(['role' => 'organizer']);
            }
            return true;
            
        } else {
            return false;
        }
        
    }
}