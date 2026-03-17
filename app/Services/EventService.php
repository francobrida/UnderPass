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

    public function filter(array $request) 
    {
        $query = Event::with('genres')
            ->where('is_verified', true)
            ->where('date', '>=', now()->toDateString());

        if (isset($request['search'])) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request['search'] . '%')
                ->orWhere('lineup', 'like', '%' . $request['search'] . '%');
            });
        }

        if (isset($request['neighborhood'])) {
            $query->where('neighborhood', $request['neighborhood']);
        }

        if (isset($request['genre'])) {
            $query->whereHas('genres', function($q) use ($request) {
                $q->where('genres.id', $request['genre']);
            });
        }

        if (isset($request['price']) && $request['price'] == 'asc') {
            $query->orderBy('price', 'asc');
        } elseif (isset($request['price']) && $request['price'] == 'desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('date', 'asc');
        }

        return $query->get(); // get() is like SELECT * FROM events
    }

    public function store($user, array $request, $file)
    {
        $request['price_info'] = $this->processPriceInfo($request);
        
        $request['flyer'] = $file->store('flyers', 'public');

        $event = $user->events()->create($request);

        if (isset($request['genres'])) {
            $event->genres()->attach($request['genres']);
        }

        return $event;
    }

    public function processPriceInfo(array $request) 
    {
        if (empty($request['price_info'])) {
            return $request['price'] == 0 ? 'Entrada gratuita' : '';
        }
        
        return $request['price_info'];
    }

    public function update($event, array $request, $file = null)
    {
        $request['price_info'] = $this->processPriceInfo($request);

        if ($file) {
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }
            $request['flyer'] = $file->store('flyers', 'public');
        }

        $event->update($request);

        if (isset($request['genres'])) {
            $event->genres()->sync($request['genres']); // sync() adds new ones and removes old ones automatically
        }

        return $event;
    }

    public function delete($event)
    {
        if ($event->flyer) {
            Storage::disk('public')->delete($event->flyer);
        }
        
        return $event->delete();
    }

    public function vouch($event, $user)
    {
        $event->vouches()->attach($user->id);

        return $this->verifyEvent($event);
    }

    public function processFlyer(Event $event, Request $request) {

        if ($request->hasFile('flyer')) {
            
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }

            return $request->file('flyer')->store('flyers', 'public');
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