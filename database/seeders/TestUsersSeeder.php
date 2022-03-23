<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating user admin@webasico.com if it does not exist.');
        User::updateOrCreate(
            ['email' => 'admin@webasico.com'],
            [
                'name'              => 'Webasico Admin',
                'password'          => Hash::make('Ar1zp3!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
