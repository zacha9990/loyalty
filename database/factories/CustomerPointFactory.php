<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Merchant;
use App\Models\Customer;
use App\Models\CustomerPoint;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerPoint>
 */
class CustomerPointFactory extends Factory
{
    protected $model = CustomerPoint::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'merchant_id' => Merchant::inRandomOrder()->first()->id,
            'points'      => $this->faker->randomElement([10, 20]),
            'created_at'  => $this->faker->dateTimeBetween('-1 months', 'now')->format('Y-m-d H:i:s'),
            'updated_at'  => $this->faker->dateTimeThisYear(),
        ];
    }
}
