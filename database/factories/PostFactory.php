<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'name'       => Str::random(16),
            'account_id' => Account::factory(),
        ];
    }
}
