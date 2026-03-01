<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
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
        return [
            'organizer_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'event_date' => fake()->dateTimeBetween('+1 days', '+1 year'),
            'location' => fake()->address(),
            'image_url' => fake()->imageUrl(),
            'visibility' => fake()->randomElement(['public', 'private']),
            'max_capacity' => fake()->numberBetween(10, 500),
            'status' => fake()->randomElement(['draft', 'published', 'cancelled']),
        ];
    }
}
