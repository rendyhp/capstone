<?php

namespace Database\Factories;

use App\Models\SetApiToken;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // atau gunakan hash langsung
            'remember_token' => Str::random(10),
            'role' => 'OWNER',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            UserProfile::create([
                'user_id' => $user->id,
                'phone' => null,
                'address' => null,
                'birth_date' => null,
                'gender' => null,
            ]);

            UserSetting::create([
                'user_id' => $user->id,
                'settings' => null,
            ]);
        });
    }



    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
