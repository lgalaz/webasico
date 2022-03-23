<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'name'    => Str::random(16),
            'user_id' => User::factory(),
        ];
    }
}
