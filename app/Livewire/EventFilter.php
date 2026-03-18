<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EventService;
use App\Models\Genre;
use App\Models\Event;

class EventFilter extends Component
{
    public $search = ''; // users input
    public $neighborhood = '';
    public $price = '';
    public $genre = '';

    public function render(EventService $eventService)
    {
        $filters = [
            'search' => $this->search, 
            'neighborhood' => $this->neighborhood,
            'genre' => $this->genre,
            'price' => $this->price,
        ];

        return view('event-filter', [
            'events' => $eventService->filter($filters),
            'genres' => Genre::all(),
            'neighborhoods' => Event::where('date', '>=', now())
                                ->distinct() 
                                ->orderBy('neighborhood', 'asc')
                                ->pluck('neighborhood'), // pluck to get just the names..
        ]);
    }
}