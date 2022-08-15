<?php

namespace Database\Seeders;

use App\Models\Documment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DocummentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
            $no_of_rows = 500000;
            $range= range( 1, $no_of_rows );
            $chunksize= 1000;

            foreach( array_chunk( $range, $chunksize ) as $chunk ){
                $documment_data = array(); /* mảng được khởi tạo lại mỗi lần lặp chính */
                foreach( $chunk as $i ){
                    $documment_data[] = array(
                        'description' => $faker->text(),
                        'content' => $faker->text(),
                        'user_id' => rand(1,500000),
                        'date_working' =>  $faker->dateTimeBetween('-5 years', now()),
                        'date_off' => $faker->dateTimeBetween('-5 years', now()),
                        'image_path' => $faker->imageUrl($width = 640, $height = 480),
                        'active' => 1,
                        'order' => 0,
                    );
                }

                Documment::insert($documment_data);
            }
    }
}


// update users set room_id=round(dbms_random.value(1,500000));
