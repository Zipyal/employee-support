<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmploymentContract;
use App\Models\User;
use Faker\Provider\ru_RU\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ru_RU');
        $person = new Person($faker);
        $gender = array_rand([
            Person::GENDER_FEMALE => Person::GENDER_FEMALE,
            Person::GENDER_MALE => Person::GENDER_MALE
        ]);
        $lastName = $person->lastName($gender);
        $firstName = $person->firstName($gender);

        $username = mb_strtolower(str_replace('\'', '', Str::transliterate($lastName . '.' . $firstName, '', true)));
        $email = $username . '@' . $faker->safeEmailDomain();

        $educations = [
            'Высшее',
            'Среднее специальное',
            'Среднее',
        ];

        $courses = [
            null,
            'Курсы 1С',
            'Курсы менеджмента',
            'Бухгалтерский учёт',
            'Китайский язык',
            'Японский язык',
            'Английский язык',
            'Немецкий язык',
            'Испанский язык',
            'Итальянский язык',
        ];

        // Учётная запись сотрудника
        $user = User::query()->create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($username),
            'role_id' => array_rand(User::ROLES),
        ]);
        // ~20% будут заблокированными
        if (rand(1, 10) <= 2) {
            $user->delete();
        }

        $createdAt = $faker->dateTimeBetween('-1 year');

        return [
            'last_name' => $lastName,
            'first_name' => $firstName,
            'patronymic' => $person->middleName($gender),
            'phone' => $faker->phoneNumber(),
            'email' => $email,
            'birth_date' => $faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'education' => array_rand(array_combine($educations, $educations)),
            'add_education' => array_rand(array_combine($courses, $courses)),
            'experience' => rand(1, 20),
            'user_id' => $user->id,
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s')),
        ];
    }
}
