<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'courseCode' => $this->faker->word,
            'description' => $this->faker->sentence(45),
            'startDate' => $this->faker->dateTimeThisYear(),
            'endDate' => $this->faker->dateTimeThisMonth('+6 weeks')
        ];
    }
}
