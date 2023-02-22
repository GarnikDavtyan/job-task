<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class LoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:login {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log user in';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $credentials = [
            'email' => $this->argument('login'),
            'password' => $this->argument('password')
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken("$user->name Access Token");
            echo $token->plainTextToken;
            return;
        }

        echo 'Invalid Credentials';
    }
}
