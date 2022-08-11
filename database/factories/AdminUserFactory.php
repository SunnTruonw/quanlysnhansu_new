<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_code' => $this->faker->user_code,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' =>  $this->faker->phone,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'address' => $this->faker->address,
            'wage' => $this->faker->address,
            'sex' => 1,
            'role' => 'user',
            'room_id' => 1,
            'city_id' => 1,
            'district_id' => 1,
            'active' =>1,
        ];
    }
}
