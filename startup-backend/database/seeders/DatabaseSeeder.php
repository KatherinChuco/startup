<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Subdepartment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Department::factory(100)->create();

        Department::all()->each(function ($department){
            if (rand(0,1)) {
                $numDeparments = rand(0, 3);
                Department::factory()->count($numDeparments)->create([
                    'superior_department_id' => $department->id,
                    'level' => $department->level+1
                ]);
            }
        });
    }
}
