<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            'user_id'=>$this->faker->randomElement($array = array(1,19)),
            'medicine_name'=> $this->faker->firstName(),
            'stock'=> $this->faker->firstName(),
            'unit_qty'=> $this->faker->numberBetween($min = 5, $max = 100),
            // 'unit_type'=> $this->faker->randomElement($array = array('Unit One', 'Unit Two')),
            'buy_price'=> $this->faker->numberBetween($min = 10, $max = 1000),
            'sell_price'=> $this->faker->numberBetween($min = 10, $max = 1000),
            'barcode'=> mt_rand(1000000000, 9999999999).date("Ydm"),
            'expiration_date'=> Carbon::now()->addMonth(rand(30,60))->format('d/m/Y'),
        ];
    }
}
