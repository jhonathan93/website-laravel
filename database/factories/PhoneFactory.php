<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Phone;
use Random\RandomException;
use App\Helpers\PhoneGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phone>
 */
class PhoneFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array {

        $type = random_int(1, 3);

        return [
            'user_id' => User::factory(),
            'uuid' => fake()->uuid(),
            'number' => PhoneGenerator::fake($type),
            'type' => $type
        ];
    }
}
