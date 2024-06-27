<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subdepartment;
use App\Models\Department;

class SubdepartmentFactory extends Factory
{
    protected $model = Subdepartment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $parentDepartmentId = Department::pluck('id')->random();
        $subdepartmentId = Department::where('id', '!=', $parentDepartmentId)->pluck('id')->random();

        return [
            'parent_department_id' => $parentDepartmentId,
            'subdepartment_id' => $subdepartmentId,
        ];
    }
}
