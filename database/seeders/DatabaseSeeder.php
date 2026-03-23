<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\VibeCheck;
use App\Models\Stamp;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([GenreSeeder::class]);

        User::factory()->create([
            'nickname' => 'Admin UnderPass',
            'email' => 'admin@underpass.com',
            'role' => UserRole::ADMIN,
            'password' => bcrypt('password'),
        ]);

        $organizer = User::factory()->create([
            'nickname' => 'RandomOrganizer',
            'email' => 'organizer@test.com',
            'role' => UserRole::ORGANIZER,
            'password' => bcrypt('password'),
        ]);

        Event::factory()->create([
            'user_id' => $organizer->id,
            'title' => 'Main Stage Techno',
            'date' => now()->addDays(5)->toDateString(),
            'is_verified' => true,
            'stamp_token' => Str::random(32),
        ]);

        Event::factory(4)->create(['user_id' => $organizer->id, 'is_verified' => true]);

        $clubber = User::factory()->create([
            'nickname' => 'RaverUser',
            'email' => 'clubber@test.com',
            'role' => UserRole::CLUBBER, 
            'password' => bcrypt('password'),
        ]);

        $pastEvent = Event::factory()->create([
            'user_id' => $organizer->id,
            'date' => now()->subDays(10)->toDateString(),
            'title' => 'Flashback Night',
            'is_verified' => true,
        ]);

        Stamp::create([
            'user_id' => $clubber->id,
            'event_id' => $pastEvent->id,
            'scanned_at' => now()->subDays(10),
        ]);

        for ($i = 0; $i < 3; ++$i) {
            VibeCheck::factory()->create([
                'event_id' => $pastEvent->id,
                'user_id' => User::factory()->create(['role' => UserRole::CLUBBER])->id,
            ]);
        }

        $waitingEvent = Event::factory()->create([
            'title' => 'Test Event no verificado',
            'is_verified' => false,
            'user_id' => User::factory()->create(['role' => UserRole::ORGANIZER])->id,
        ]);
        $waitingEvent->vouches()->attach(User::factory(2)->create()->pluck('id'));

        $extraPastEvents = Event::factory(2)->create([
            'user_id' => $organizer->id, 
            'date' => now()->subMonths(1)->toDateString(),
            'is_verified' => true,
        ]);

        foreach ($extraPastEvents as $event) {
            Stamp::create([
                'user_id' => $clubber->id,
                'event_id' => $event->id,
                'scanned_at' => now()->subDays(20),
            ]);
        }

        $pastEventForFeedback = Event::factory()->create([
            'user_id' => $organizer->id,
            'title' => 'Noche de Vinilo & Techno',
            'date' => now()->subDay()->toDateString(), 
            'is_verified' => true,
            'stamp_token' => Str::random(32),
        ]);

        Stamp::create([
            'user_id' => $clubber->id,
            'event_id' => $pastEventForFeedback->id,
            'scanned_at' => now()->subDay()->subHours(5),
        ]);

        for ($i = 0; $i < 2; ++$i) {
            VibeCheck::factory()->create([
                'event_id' => $pastEventForFeedback->id,
                'user_id' => User::factory()->create(['role' => UserRole::CLUBBER])->id,
            ]);
        }
    }
    
}