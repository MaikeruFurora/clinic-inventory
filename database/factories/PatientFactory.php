<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'sex' => $this->faker->randomElement($array = array('Male', 'Female')),
            'date_of_birth' => date("d/m/Y", strtotime($this->faker->date())),
            'status' => $this->faker->randomElement($array = array('Single', 'Married')),
            'address' => $this->faker->streetName(),
            'contact_no' => '00'+$this->faker->numberBetween($min = 8888888888, $max = 9999999999),
        ];
    }
}
