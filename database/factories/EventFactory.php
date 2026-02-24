<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        $neighborhoods = ['Poblenou', 'Gràcia', 'Raval', 'Eixample', 'Poble Sec', 'Sant Antoni', 'Born'];

        return [
            'user_id' => \App\Models\User::factory(), 
            'title' => fake()->randomElement(['Midnight Ritual', 'Industrial Bass', 'Techno Warehouse']),
            'lineup' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'date' => fake()->dateTimeBetween('now', '+2 months'),
            'start_time' => '23:00:00',
            'end_time' => '06:00:00',
            'price' => fake()->randomFloat(2, 10, 50),
            'price_info' => 'Entrada anticipada',
            'location_name' => fake()->company(),
            'neighborhood' => fake()->randomElement($neighborhoods),
            'flyer' => 'flyer.jpg',
            'is_verified' => false,
            'is_18_plus' => true,
        ];
    }
}
