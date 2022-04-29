<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating user admin@webasico.com if it does not exist.');
        $user = User::updateOrCreate(
            [ 'email' => 'admin@webasico.com' ],
            [
                'name'              => 'Webasico Admin',
                'password'          => Hash::make('Ar1zp3!'),
                'email_verified_at' => now(),
            ]
        );

        Account::updateOrCreate(
            [ 'user_id' => $user->user_id ], 
            [ 'name'    => 'admin' ]
        );
    }
}
