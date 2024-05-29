<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmploymentContract;
use App\Models\Role;
use App\Models\User;
use Faker\Provider\ru_RU\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
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

        // Avatar
        $demoAvatarsDir = '/img/demo_avatars/' . $gender;
        $images = Storage::disk('public')->files($demoAvatarsDir);
        // dd($images);
        $randomImageFilepath = array_rand(array_flip($images));


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
        /** @var User $user */
        $user = User::query()->create([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($email),
        ]);

        $user->assignRole(
            array_rand(array_flip([
                Role::ROLE_MENTOR,
                Role::ROLE_EMPLOYEE,
                Role::ROLE_INTERN,
            ]))
        );

        // ~20% будут заблокированными
        if (rand(1, 10) <= 2) {
            $user->delete();
        }

        $createdAt = $faker->dateTimeBetween('-1 year');

        return [
            'last_name' => $lastName,
            'first_name' => $firstName,
            'patronymic' => $person->middleName($gender),
            'gender' => $gender,
            'image_filepath' => $randomImageFilepath,
            'phone' => $faker->phoneNumber(),
            'email' => $email,
            'birth_date' => $faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'education' => array_rand(array_combine($educations, $educations)),
            'add_education' => array_rand(array_combine($courses, $courses)),
            'experience' => rand(1, 20),
            'user_uuid' => $user->uuid,
            'created_at' => $createdAt,
            'updated_at' => $faker->dateTimeBetween($createdAt->format('Y-m-d H:i:s')),
        ];
    }
}
