<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id'=>1,
            'blood_pressure'=>$this->faker->firstName(),
            'temperature'=>$this->faker->firstName(),
            'pulse'=>$this->faker->firstName(),
            'respiratory_rate'=>$this->faker->firstName(),
            'height'=>$this->faker->firstName(),
            'weight'=>$this->faker->firstName(),
            'symptom'=>$this->faker->firstName(),
            'details'=>$this->faker->firstName(),
            'treatment'=>$this->faker->firstName(),
            'remarks'=>$this->faker->firstName(),
        ];
    }
}
