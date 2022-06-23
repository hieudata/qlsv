<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birthday' => $this->faker->date(),
            'gender' => $this->faker->randomDigitNot(5),
            'avatar' => 'admin.jpg',
            'faculty_id' => '1',
            // 'avatar' => $this->faker->image($dir = '/tmp', $width = 640, $height = 480)
        ];
    }
}
