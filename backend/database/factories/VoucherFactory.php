<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'crew_name'    => $this->faker->name(),
            'crew_id'      => $this->faker->numerify('#####'),
            'flight_number'=> 'GA' . $this->faker->numberBetween(100, 999),
            'flight_date'  => $this->faker->date('Y-m-d'),
            'aircraft_type'=> $this->faker->randomElement(['ATR', 'Airbus 320', 'Boeing 737 Max']),
            'seat1'        => '1A',
            'seat2'        => '2C',
            'seat3'        => '3D',
        ];
    }
}
