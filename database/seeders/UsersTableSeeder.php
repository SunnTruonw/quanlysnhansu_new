<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\User;

class UsersTableSeeder extends Seeder
{

    public function run(Faker $faker)
    {
            $no_of_rows = 500000;
            $range= range( 1, $no_of_rows );
            $chunksize= 1000;

            foreach( array_chunk( $range, $chunksize ) as $chunk ){
                $user_data = array(); /* mảng được khởi tạo lại mỗi lần lặp chính */
                foreach( $chunk as $i ){
                    $user_data[] = array(
                        'user_code' => $faker->postcode,
                        'name' => $faker->userName,
                        'email' => $faker->unique()->safeEmail,
                        'phone' =>  $faker->phoneNumber,
                        'password' => '$2y$10$H.IecOXydr8y3nik8wTSdeyWB8lXsh6f/WvQlVgqPrMV4qyyvNC7q', // password
                        'address' => $faker->address,
                        'wage' => $faker->numerify('##########'),
                        'sex' => $faker->boolean(50) ? 1 : 0,
                        'role' => $faker->boolean(50) ? 'admin' : 'user',
                        'room_id' => rand(1,500000),
                        'city_id' => 1,
                        'district_id' => 1,
                        'active' => (int)$faker->boolean(50),
                        'avatar_path' => $faker->imageUrl($width = 640, $height = 480),
                    );
                }
                User::insert( $user_data );
            }

    }
}
