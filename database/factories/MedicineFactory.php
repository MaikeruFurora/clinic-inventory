<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'medicine_name'=> $this->faker->firstName(),
            'medicine_pharma'=> $this->faker->firstName(),
            'medicine_cabinet'=> $this->faker->firstName(),
            'unit_qty'=> $this->faker->numberBetween($min = 10, $max = 1000),
            'unit_type'=> $this->faker->randomElement($array = array('Unit One', 'Unit Two')),
            'buy_price'=> $this->faker->numberBetween($min = 10, $max = 1000),
            'sell_price'=> $this->faker->numberBetween($min = 10, $max = 1000),
            'type'=> $this->faker->randomElement($array = array('Type One', 'Type Two')),
            'expiration_date'=> $this->faker->firstName(),
        ];
    }
}
