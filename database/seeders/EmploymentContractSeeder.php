<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmploymentContract;
use Illuminate\Database\Seeder;

class EmploymentContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeesCount = Employee::query()->get()->count();
        EmploymentContract::factory($employeesCount)->create();
    }
}
