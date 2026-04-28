<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'document_type'   => $this->faker->randomElement(['CC', 'TI', 'CE']),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'first_name'      => $this->faker->firstName(),
            'middle_name'     => $this->faker->optional()->firstName(),
            'last_name'       => $this->faker->lastName(),
            'second_lastname' => $this->faker->optional()->lastName(),
            'email'           => $this->faker->unique()->safeEmail(),
            'phone_number'    => $this->faker->unique()->numerify('3#########'), // Celulares en Colombia
            'status'          => 'active',
            'role'            => 'member',
            'password'        => static::$password ??= Hash::make('password'),
            'remember_token'  => Str::random(10),
            'must_change_password' => false,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'member',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
