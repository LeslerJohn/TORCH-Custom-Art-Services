<?php

namespace Database\Factories;

use App\Models\ArtistProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArtistProfile>
 */
class ArtistProfileFactory extends Factory
{
    protected $model = ArtistProfile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone_number' => $this->faker->phoneNumber,
            'location' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'username' => $this->faker->userName,
            'birthdate' => $this->faker->date,
            'bio' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'semi-verified', 'fully-verified', 'unverified']),
            'is_suspended' => $this->faker->boolean,
            'rating' => $this->faker->numberBetween(1, 5),
            'available' => $this->faker->boolean,
        ];
    }
}
