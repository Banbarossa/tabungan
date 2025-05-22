<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => fake()->name(),
            'account_number' => fake()->numerify('###########'),
            'nisn' => fake()->optional()->numerify('##########'),
            'nis' => fake()->optional()->numerify('######'),
            'nama_ibu' => fake()->optional()->name('female'),
            'status' => fake()->boolean(90),
            'saldo' => fake()->numberBetween(0,900000),
            'send_notification' => fake()->boolean(30),
            'notification_target' => fake()->optional()->randomElement(['whatsapp', 'email']),
            'notification_account' => fake()->optional()->email(),
        ];
    }
}
