<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateAdmin extends Command
{
    const DEFAULT_GENDER = 'male';
    const DEFAULT_LAST_NAME = 'Админов';
    const DEFAULT_FIRST_NAME = 'Админ';
    const DEFAULT_PATRONYMIC = 'Админович';

    const DEFAULT_BIRTH_DATE = '1980-01-01';
    const DEFAULT_PHONE = '+7 (999) 111-11-11';
    const DEFAULT_EDUCATION = 'Высшее';
    const DEFAULT_EXPERIENCE = 20;

    const DEFAULT_USERNAME = 'admin';
    const DEFAULT_EMAIL = 'admin@admin';
    const DEFAULT_PASSWORD = '123456';

    protected $signature = 'app:create-admin {--auto}';

    protected $description = 'Command description';

    public bool $auto;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isAuto = $this->input->getOption('auto');
        if ($isAuto) {
            $gender = self::DEFAULT_GENDER;
            $lastName = self::DEFAULT_LAST_NAME;
            $firstName = self::DEFAULT_FIRST_NAME;
            $patronymic = self::DEFAULT_PATRONYMIC;
            $birthDate = self::DEFAULT_BIRTH_DATE;
            $education = self::DEFAULT_EDUCATION;
            $experience = self::DEFAULT_EXPERIENCE;
            $phone = self::DEFAULT_PHONE;

            $username = self::DEFAULT_USERNAME;
            $email = self::DEFAULT_EMAIL;
            $password = self::DEFAULT_PASSWORD;

        } else {

            while (!isset($gender) || !strlen($gender) || !in_array($gender, ['male', 'female'])) {
                $gender = $this->ask('Укажите пол: "male" (мужской) или "female" (женский):', self::DEFAULT_GENDER);
            }

            while (!isset($lastName) || !strlen($lastName)) {
                $lastName = $this->ask('Укажите фамилию:', self::DEFAULT_LAST_NAME);
            }

            while (!isset($firstName) || !strlen($firstName)) {
                $firstName = $this->ask('Укажите имя:', self::DEFAULT_FIRST_NAME);
            }

            while (!isset($patronymic) || !strlen($patronymic)) {
                $patronymic = $this->ask('Укажите отчество:', self::DEFAULT_PATRONYMIC);
            }

            while (!isset($birthDate) || !strlen($birthDate) || !Carbon::parse($birthDate)) {
                $birthDate = $this->ask('Укажите дату рожения в формате YYYY-MM-DD:', self::DEFAULT_BIRTH_DATE);
            }

            while (!isset($phone) || !strlen($phone)) {
                $phone = $this->ask('Введите телефонный номер:', self::DEFAULT_PHONE);
            }

            while (!isset($education) || !strlen($education)) {
                $education = $this->ask('Укажите образование:', self::DEFAULT_EDUCATION);
            }

            while (!isset($experience) || !strlen($experience)) {
                $experience = $this->ask('Укажите образование:', self::DEFAULT_EXPERIENCE);
            }

            while (!isset($username) || !strlen($username)) {
                $username = $this->ask('Укажите имя пользователя (логин):', self::DEFAULT_USERNAME);
            }

            while (!isset($email) || !strlen($email)) {
                $email = $this->ask('Укажите адрес эл. почты:', self::DEFAULT_EMAIL);
            }

            while (!isset($password) || !isset($passwordConfirm) || $password !== $passwordConfirm) {
                $password = $this->secret('Введите пароль:');
                $passwordConfirm = $this->secret('Введите пароль ещё раз:');
                if (!strlen($password) && !strlen($passwordConfirm)) {
                    $password = $passwordConfirm = self::DEFAULT_PASSWORD;
                }
            }
        }

        if (self::DEFAULT_USERNAME === $username) {
            $this->output->writeln('По умолчанию имя пользователя (логин): <fg=cyan>' . self::DEFAULT_USERNAME .'</>');
        }
        if (self::DEFAULT_EMAIL === $email) {
            $this->output->writeln('По умолчанию адрес эл. почты: <fg=cyan>' . self::DEFAULT_EMAIL . '</>');
        }
        if (self::DEFAULT_PASSWORD === $password) {
            $this->output->writeln('По умолчанию пароль: <fg=cyan>' . self::DEFAULT_PASSWORD . '</>');
        }

        try {
            $faker = \Faker\Factory::create('ru_RU');

            $employee = Employee::query()->create([
                'gender' => $gender,
                'last_name' => $lastName,
                'first_name' => $firstName,
                'patronymic' => $patronymic,
                'phone' => $phone,
                'email' => $email,
                'birth_date' => $birthDate,
                'education' => $education,
                'experience' => $experience,
            ]);

            /** @var User $user */
            $user = User::query()->create([
                'name' => $username,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $employee->user_uuid = $user->uuid;
            $employee->save();

            /** @var Role $role */
            $role = Role::query()->createOrFirst([
                'name' => Role::ROLE_ADMIN,
            ]);

            $user->assignRole($role);

        } catch (\Throwable $e) {
            $this->output->error($e->getMessage());
            exit(self::FAILURE);
        }

        $this->output->success('Администратор успешно добавлен.');
        exit(self::SUCCESS);
    }
}
