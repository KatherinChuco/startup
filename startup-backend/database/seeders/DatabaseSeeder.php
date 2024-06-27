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
        Department::factory(5)->create();
        Department::factory(1)->create();

        Department::factory(10)
        ->has(
            Subdepartment::factory()->count(1)
        )->create();
    }
}
