<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [


            'student_id'=>Student::factory(),
            'amount'=>fake()->numberBetween(10000,100000),
            'latest_saldo'=>fake()->numberBetween(0,100000),
            'type'=>fake()->randomElement(['setor','tarik']),
        ];
    }
}
