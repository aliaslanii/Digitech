<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddressCustomer>
 */
class AddressCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name"=> fake()->name(),
            "mobile"=> fake()->phoneNumber(),
            "address"=> fake()->address(),
            "states_id"=> State::factory(),
            "cities_id"=> City::factory() ,
            "zipCode"=> random_int(1,10000),
            "plate"=> random_int(1,100),
            "unit"=> random_int(1,100),
            "user_id"=> User::factory(),
        ];
    }
}
