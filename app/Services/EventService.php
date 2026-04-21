<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class EventService {

    public const int VOUCHES_TO_VERIFY = 3;

    public function filter(array $request): Collection 
    {
        $query = Event::with('genres')
            ->where('is_verified', true)
            ->where('date', '>=', now()->toDateString());

        if (!empty($request['search'])) {
            $search = '%' . $request['search'] . '%';
            $query->whereAny(['title', 'lineup'], 'like', $search);
        }

        if (!empty($request['neighborhood'])) {
            $query->where('neighborhood', $request['neighborhood']);
        }

        if (!empty($request['genre'])) {
            $query->whereHas('genres', function($genreQuery) use ($request) {
                $genreQuery->where('genres.id', $request['genre']);
            });
        }

        $order = $request['price'] ?? null;

        if ($order === 'asc' || $order === 'desc') {
            $query->orderBy('price', $order);
        } else {
            $query->orderBy('date', 'asc');
        }

        return $query->get();
    }

    public function store(User $user, array $request, UploadedFile $file): Event
    {
        $request['price_info'] = $this->processPriceInfo($request);
        
        $request['flyer'] = $file->store('flyers', 'public');

        $request['stamp_token'] = Str::random(32); 

        $event = $user->events()->create($request);

        if (isset($request['genres'])) {
            $event->genres()->attach($request['genres']);
        }

        return $event;
    }

    public function processPriceInfo(array $request): string 
    {
        if (empty($request['price_info'])) {
            return $request['price'] == 0 ? 'Entrada gratuita' : '';
        }
        
        return $request['price_info'];
    }

    public function update(Event $event, array $request, ?UploadedFile $file = null): Event
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
            $event->genres()->sync($request['genres']);
        }

        return $event;
    }

    public function delete(Event $event): bool
    {
        if ($event->flyer) {
            Storage::disk('public')->delete($event->flyer);
        }
        
        return (bool) $event->delete();
    }

    public function vouch(Event $event, User $user): bool
    {
        $event->vouches()->attach($user->id);

        return $this->verifyEvent($event);
    }

    public function processFlyer(Event $event, Request $request): ?string 
    {
        if ($request->hasFile('flyer')) {
            
            if ($event->flyer) {
                Storage::disk('public')->delete($event->flyer);
            }

            return $request->file('flyer')->store('flyers', 'public');
        }

        return null;
    }

    public function verifyEvent(Event $event): bool 
    {
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