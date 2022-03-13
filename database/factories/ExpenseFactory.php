<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>1,
            'description'=>$this->faker->paragraph($nbSentences = 3, $variableNbSentences = true) ,
            'amount'=>rand(100,1000)
        ];
    }
}
