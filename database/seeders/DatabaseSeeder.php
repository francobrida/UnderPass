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
        
        $this->call([
            GenreSeeder::class,
        ]);

        
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

        
        Event::factory(5)->create(['user_id' => $organizer->id]);

        $clubber = User::factory()->create([
            'nickname' => 'RaverUser',
            'email' => 'clubber@test.com',
            'role' => UserRole::CLUBBER, // O el nombre que uses en tu Enum para clubber
            'password' => bcrypt('password'),
        ]);

        // 5. EVENTO PASADO + SELLO + VIBECHECK (Para testear feedback)
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

        VibeCheck::factory(3)->create([
            'event_id' => $pastEvent->id,
            'user_id' => User::factory()->create()->id,
        ]);
        
        $pendingEvent = Event::factory()->create([
            'title' => 'Test Event no verificado',
            'is_verified' => false,
        ]);
        $pendingEvent->vouches()->attach(User::factory(2)->create()->pluck('id'));
    }
}