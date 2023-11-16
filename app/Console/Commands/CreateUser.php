<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $email = $this->ask('Please enter your E-Mail.');
        $password = $this->askForPassword();

        try {
            $user = new User();
            $user->email = $email;
            $user->password =  Hash::make($password);
            $user->save();
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $this->info('User created successfully!');
        $this->info('New user id: ' . $user->id);
    }

    private function askForPassword()
    {
        $password = $this->secret('Please enter a new password.');
        $password_confirmation = $this->secret('Please confirm the password');

        if ($password_confirmation !== $password) {
            $this->error("Passwords did not match");
            $password = $this->askForPassword();
        }

        return $password;
    }
}
