<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Phone;
use App\Models\Address;
use Illuminate\Support\Str;
use App\Helpers\CpfGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory {

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'admin123';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'date_of_birth' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'cpf' => CpfGenerator::fake(),
            'email_verified_at' => now(),
            'password' => Hash::make(static::$password),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * @return Factory|UserFactory
     */
    public function configure(): Factory|UserFactory {
        return $this->afterCreating(function (User $user) {
            Phone::factory()->create([
                'user_id' => $user->id,
                'is_primary' => true
            ]);

            $multiple = random_int(1, 100000);

            if ($multiple % 2 === 0) Phone::factory()->create([
                'user_id' => $user->id,
                'is_primary' => false
            ]);

            Address::factory()->create([
                'user_id' => $user->id,
                'is_primary' => true
            ]);

            $multiple = random_int(1, 100000);

            if ($multiple % 2 === 0) Address::factory()->create([
                'user_id' => $user->id,
                'is_primary' => false
            ]);
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
