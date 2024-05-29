<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Briefing>
 */
class BriefingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');

        $textParagraphs = [];
        for ($i = 0; $i < 5; $i++) {
            $textParagraphs[] = $faker->realText(rand(200, 800), rand(3, 5));
        }

        $randomUser = User::query()->withoutRole([Role::ROLE_INTERN, Role::ROLE_EMPLOYEE])->inRandomOrder()->first();
        $randomPublished = array_rand(array_flip(range(0, 10))) < 3;
        $createdAt = $faker->dateTimeBetween('-1 year');

        return [
            'subject' => $faker->realText(50),
            'text' => implode(PHP_EOL . PHP_EOL, $textParagraphs),
            'author_uuid' => $randomUser->uuid ?? null,
            'published' => $randomPublished,
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s')),
        ];
    }
}
