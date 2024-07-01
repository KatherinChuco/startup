<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

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
            'department_name' => $this->faker->unique()->word() . ' '. $this->faker->numberBetween(1, 100),
            'superior_department_id' => null,
            'ambassador_name' => $this->faker->name(),
            'employee_count' => $this->faker->numberBetween(5, 50),
            'level' => $this->faker->numberBetween(1, 3),
        ];
    }
}
