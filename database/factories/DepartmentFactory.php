<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
    /**
    public function run()
    {
    Department::factory(8)->create()->each(function(Department $department){
        City::factory(8)->create([
            'department_id' => $department->id
        ])->each(function(City $city){
            District::factory(8)->create([
                'city_id' => $city->id
                ]);
            });
        });
    }**/
}
