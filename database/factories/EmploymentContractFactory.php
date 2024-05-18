<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmploymentContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmploymentContract>
 */
class EmploymentContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');

        $employee = Employee::query()->without('contracts')->inRandomOrder()->first();

        $createdAt = $faker->dateTimeBetween('-1 year');
        $updatedAt = $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s'));

        $departmentsAndPositions = [
            'Отдел кадров' => [
                'Рекрутер',
                'Инспектор по кадрам',
                'Специалист по персоналу',
                'Специалист по кадровому учету',
            ],
            'Бухгалтерия' => [
                'Бухгалтер-стажер',
                'Помощник бухгалтера',
                'Бухгалтер',
                'Старший бухгалтер',
                'Главный бухгалтер',
            ],
            'Отдел проектирования' => [
                'Инженер-проектировщик',
                'Техник-проектировщик',
                'Инженер-конструктор',
            ],
            'Отдел разработки' => [
                'Программист PHP',
                'Программист JavaScript',
                'Программист Python',
                'Программист Java',
                'HTML-верстальщик',
                'Web-дизайнер',
                'Сетевой инженер',
                'Системный администратор',
                'Системный аналитик',
            ],
        ];

        $department = array_rand($departmentsAndPositions);
        $position = array_rand(array_flip($departmentsAndPositions[$department]));

        return [
            'number' => $faker->randomNumber(6),
            'register_date' => $createdAt->format('Y-m-d'),
            'end_date' => $updatedAt->format('Y-m-d'),
            'register_address' => $faker->city(),
            'department' => $department,
            'position' => $position,
            'salary' => rand(100, 300) * 1000,
            'rate' => min(rand(4, 20), 8),
            'employee_uuid' => $employee->uuid,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
