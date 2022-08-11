<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $factory->define(App\Models\User::class, function (Faker $faker) {
            return [
                'user_code' => $faker->user_code,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' =>  $faker->phone,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'address' => $faker->address,
                'wage' => $faker->address,
                'sex' => 1,
                'role' => 'user',
                'room_id' => 1,
                'city_id' => 1,
                'district_id' => 1,
                'active' =>1,
            ];
        });
    }
}
