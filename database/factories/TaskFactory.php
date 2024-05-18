<?php

namespace Database\Factories;

use App\Models\Briefing;
use App\Models\Employee;
use App\Models\Material;
use App\Models\Task;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');

        $randomEmployee = Employee::query()->inRandomOrder()->first();
        $randomTest = Test::query()->inRandomOrder()->first();
        $randomBriefing = Briefing::query()->inRandomOrder()->first();
        $randomMaterial = Material::query()->inRandomOrder()->first();

        $randomUser = User::query()->whereIn('role_id', [User::ROLE_MENTOR, User::ROLE_ADMIN])->inRandomOrder()->first();
        $createdAt = $faker->dateTimeBetween('-1 year');
        $updatedAt = $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s'));

        return [
            'subject' => rtrim($faker->realText(50), '!?. '),
            'status' => array_rand(array_flip(Task::STATUSES)),
            'type' => array_rand(array_flip(Task::TYPES)),
            'start_date' => $createdAt->format('Y-m-d'),
            'end_date' => $createdAt->modify('+' . rand(1, 5) . ' day'),
            'description' => rtrim($faker->realText(rand(200, 500)), '!?. '),
            'employee_uuid' => $randomEmployee->uuid,
            'test_uuid' => $randomTest->uuid,
            'briefing_uuid' => $randomBriefing->uuid,
            'material_uuid' => $randomMaterial->uuid,
            'author_id' => $randomUser->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
