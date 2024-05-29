<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // роль "Стажёр"
        $internEmail = 'intern@intern';

        /** @var User $internUser */
        $internUser = User::query()->create([
            'name' => 'intern',
            'email' => $internEmail,
            'password' => bcrypt($internEmail)
        ]);
        $internUser->assignRole(Role::ROLE_INTERN);

        Employee::query()->create([
            'last_name' => 'Стажёров',
            'first_name' => 'Стажёр',
            'patronymic' => 'Стажёрович',
            'gender' => 'male',
            'phone' => '+7 (999) 222-22-22',
            'email' => $internEmail,
            'birth_date' => '2000-01-01',
            'education' => 'Среднее',
            'experience' => 0,
            'user_uuid' => $internUser->uuid,
        ]);


        // роль "Сотрудник"
        $employeeEmail = 'employee@employee';

        /** @var User $employeeUser */
        $employeeUser = User::query()->create([
            'name' => 'employee',
            'email' => $employeeEmail,
            'password' => bcrypt($employeeEmail)
        ]);
        $employeeUser->assignRole(Role::ROLE_EMPLOYEE);

        Employee::query()->create([
            'last_name' => 'Сотрудников',
            'first_name' => 'Сотрудник',
            'patronymic' => 'Сотрудникович',
            'gender' => 'male',
            'phone' => '+7 (999) 333-33-33',
            'email' => $employeeEmail,
            'birth_date' => '1995-01-01',
            'education' => 'Среднее',
            'experience' => 5,
            'user_uuid' => $employeeUser->uuid,
        ]);


        // роль "Наставник"
        $mentorEmail = 'mentor@mentor';

        /** @var User $mentorUser */
        $mentorUser = User::query()->create([
            'name' => 'mentor',
            'email' => $mentorEmail,
            'password' => bcrypt($mentorEmail)
        ]);
        $mentorUser->assignRole(Role::ROLE_MENTOR);

        Employee::query()->create([
            'last_name' => 'Наставников',
            'first_name' => 'Наставник',
            'patronymic' => 'Наставникович',
            'gender' => 'male',
            'phone' => '+7 (999) 444-44-44',
            'email' => $mentorEmail,
            'birth_date' => '1990-01-01',
            'education' => 'Высшее',
            'experience' => 10,
            'user_uuid' => $mentorUser->uuid,
        ]);

        // Случайные сотрудники
        Employee::factory(7)->create();
    }
}
