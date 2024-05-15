<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Administrator\'s name:', 'admin');
        $email = $this->ask('Administrator\'s email:');

        while (!isset($password) || !isset($passwordRepeat) || $password !== $passwordRepeat) {
            $password = $this->secret('Administrator\'s password:');
            $passwordRepeat = $this->secret('Repeat administrator\'s password:');
        }

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->output->success('The administrator has been successfully created.');
    }
}
