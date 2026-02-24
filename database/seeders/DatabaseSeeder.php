<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\UserRole; // Importante para asignar el rol

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create an admin user
        User::factory()->create([
            'nickname' => 'Admin UnderPass', // Corregido de 'name' a 'nickname'
            'email' => 'admin@underpass.com',
            'role' => UserRole::ADMIN,
            'points' => 100,
        ]);

    
        $this->call([
            GenreSeeder::class,
            EventSeeder::class,
        ]);

        // 3. Create 10 events with admin user as the organizer
        \App\Models\Event::factory(10)->create();
    }
}
