<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use Random\RandomException;
use App\Helpers\AddressGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array {

        $address = AddressGenerator::fake();

        return [
            'user_id' => User::factory(),
            'uuid' => fake()->uuid(),
            'street' => $address['street'],
            'number' => random_int(100, 999),
            'district' => $address['district'],
            'city' => $address['city'],
            'state' => $address['state'],
            'zip_code' => $address['zip_code']
        ];
    }
}
