<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
            'image' => 'subcategories/' . $this->faker->image(storage_path('app/public/subcategories'), 640, 480, null, false)
        ];
    }
}
