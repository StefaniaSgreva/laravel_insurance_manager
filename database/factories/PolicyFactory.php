<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\Policy;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policy>
 */
class PolicyFactory extends Factory
{
    protected $model = Policy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['auto', 'home', 'life', 'health'];
        $statuses = ['active', 'expired', 'cancelled', 'pending'];

        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $endDate = clone $startDate;
        $endDate->modify('+' . rand(6, 24) . ' months');

        return [
            'client_id' => Client::factory(),
            'policy_number' => strtoupper('POL-' . $this->faker->unique()->bothify('??####')),
            'type' => $this->faker->randomElement($types),
            'premium' => $this->faker->randomFloat(2, 100, 5000),
            'coverage_amount' => $this->faker->randomFloat(2, 10000, 1000000),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement($statuses),
            'details' => json_encode([
                'vehicle' => $this->faker->randomElement(['Fiat', 'Ford', 'Toyota', 'BMW', 'Audi']),
                'year' => $this->faker->year(),
                'property_address' => $this->faker->address(),
            ]),
            'created_at' => $startDate,
            'updated_at' => now(),
        ];
    }

    /**
     * Stato attivo (più frequente)
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'active',
            'end_date' => now()->addMonths(rand(6, 12)),
        ]);
    }

    /**
     * Stato scaduto
     */
    public function expired(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'expired',
            'end_date' => now()->subDays(rand(1, 30)),
        ]);
    }
}
