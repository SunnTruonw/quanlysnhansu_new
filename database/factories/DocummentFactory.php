<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Documment;

class DocummentFactory extends Factory
{

    protected $model = Documment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(),
            'content' => $this->faker->text(),
            'date_working' =>  $this->faker->dateTimeBetween('-50 days', now()),

            'date_off' => $this->faker->dateTimeBetween('-20 days', now()),
            'image_path' => $this->faker->imageUrl($width = 640, $height = 480),
            'active' => 1,
            'order' => 0,
        ];
    }
}
