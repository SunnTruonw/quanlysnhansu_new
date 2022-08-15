<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Room;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $no_of_rows = 50;
            $range= range( 1, $no_of_rows );
            $chunksize= 1000;

            foreach( array_chunk( $range, $chunksize ) as $chunk ){
                $room_data = array(); /* mảng được khởi tạo lại mỗi lần lặp chính */
                foreach( $chunk as $i ){
                    $room_data[] = array(
                        'name' => $faker->userName(),
                        'description' => $faker->text(),
                        'avatar_path' => $faker->imageUrl($width = 640, $height = 480),
                        'active' => 1,
                        'order' => 0,
                    );
                }

                Room::insert( $room_data );
            }
    }
}
