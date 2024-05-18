<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    const DEFAULT_NAME = 'admin';
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
            $name = self::DEFAULT_NAME;
            $email = self::DEFAULT_EMAIL;
            $password = self::DEFAULT_PASSWORD;

        } else {
            while (!isset($name) || !strlen($name)) {
                $name = $this->ask('Administrator\'s name:', self::DEFAULT_NAME);
            }

            while (!isset($email) || !strlen($email)) {
                $email = $this->ask('Administrator\'s email:', self::DEFAULT_EMAIL);
            }

            while (!isset($password) || !isset($passwordConfirm) || $password !== $passwordConfirm) {
                $password = $this->secret('Administrator\'s password:');
                $passwordConfirm = $this->secret('Repeat administrator\'s password:');
                if (!strlen($password) && !strlen($passwordConfirm)) {
                    $password = $passwordConfirm = self::DEFAULT_PASSWORD;
                }
            }
        }

        if (self::DEFAULT_NAME === $name) {
            $this->output->writeln('Default name used: <fg=cyan>' . self::DEFAULT_NAME .'</>');
        }
        if (self::DEFAULT_EMAIL === $email) {
            $this->output->writeln('Default email used: <fg=cyan>' . self::DEFAULT_EMAIL . '</>');
        }
        if (self::DEFAULT_PASSWORD === $password) {
            $this->output->writeln('Default password used: <fg=cyan>' . self::DEFAULT_PASSWORD . '</>');
        }

        try {
            User::query()->create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => User::ROLE_ADMIN,
            ]);
            $this->output->success('The administrator has been successfully created.');

        } catch (\Throwable $e) {
            $this->output->error($e->getMessage());
        }
    }
}
