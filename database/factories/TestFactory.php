<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Test>
 */
class TestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');

        $randomUser = User::query()->withoutRole([Role::ROLE_INTERN, Role::ROLE_EMPLOYEE])->inRandomOrder()->first();
        $createdAt = $faker->dateTimeBetween('-1 year');

        return [
            'category' => $faker->jobTitle(),
            'subject' => rtrim($faker->realText(50), '!?. '),
            'author_uuid' => $randomUser->uuid,
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s')),
        ];
    }
}
