<?php

namespace App\Console\Commands;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GetKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getkey:getkey {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate key to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Invalid login or password');
            return;
        }

        if (Hash::check($password, $user->password)) {
            // Пароль верен
            // Генерация токена и сохранение его в базе данных
            $token = bin2hex(random_bytes(16));
            $expiration = now()->addMinutes(5);

            $user->api_token = $token;
            $user->api_token_expiration = $expiration;
            $user->save();

            $this->info("Token generated successfully. Token: $token. Expiration: $expiration");
        } else {
            // Пароль неверный
            $this->error('Invalid login or password');
        }
    }
}
