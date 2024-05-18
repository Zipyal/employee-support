<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
            EmployeeSeeder::class,
            EmploymentContractSeeder::class,
            MaterialSeeder::class,
            BriefingSeeder::class,
            TestSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
