<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskComment>
 */
class TaskCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');

        $randomText = $faker->realText(mt_rand(20, 200));
        $randomTask = Task::query()->inRandomOrder()->first();
        $randomUser = User::query()->inRandomOrder()->first();

        return [
            'text' => $randomText,
            'author_uuid' => $randomUser->uuid,
            'task_id' => $randomTask->id,
            'created_at' => $faker->dateTimeBetween($randomTask->created_at, Carbon::parse('+10 minutes')),
        ];
    }
}
