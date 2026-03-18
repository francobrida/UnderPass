<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\VibeCheck;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $flyers = ['flyers/party1.jpg', 'flyers/party2.jpg', 'flyers/party3.jpg'
        ];

        $organizer = User::factory()->create([
            'nickname' => 'RandomGuy',
            'email' => 'organizer@test.com',
            'role' => 'organizer',
            'password' => bcrypt('password'), // this hashes the password, in this case, "password"
        ]);

        \App\Models\Event::factory(5)->create([
            'user_id' => $organizer->id,
            'flyer'   => fake()->randomElement($flyers),
        ]);

        Event::factory(3)->create([
            'user_id' => $organizer->id,
            'flyer' => fake()->randomElement($flyers),
        ]);

        $pastEvents = Event::factory(2)->create([
            'user_id' => $organizer->id,
            'date' => now()->subDays(15)->toDateString(), 
            'title' => 'Flashback Night',
            'flyer' => fake()->randomElement($flyers),
            'is_verified' => true,
        ]);

        foreach ($pastEvents as $event) { 
            VibeCheck::factory(3)->create([ // anonymous feedback for past events
                'event_id' => $event->id,
                'user_id' => User::factory()->create(['role' => 'clubber'])->id,
            ]);
        } 

        User::factory()->create([
            'nickname' => 'Admin',
            'email' => 'admin@underpass.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
        
        User::factory()->create([
            'nickname' => 'RaverUser',
            'email' => 'clubber@test.com',
            'role' => 'clubber',
            'password' => bcrypt('password'),
        ]);

        $raver = User::where('email', 'clubber@test.com')->first();

        if ($pastEvents->isNotEmpty()) { 
            \App\Models\Stamp::create([ // stamp for past event
                'user_id' => $raver->id,
                'event_id' => $pastEvents->random()->id,
                'stamp_token' => \Illuminate\Support\Str::random(32),
            ]);
        } 
    }
}