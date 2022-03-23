<?php

namespace Database\Factories;

use App\Models\Template;
use App\Models\Account;
use App\Models\Website;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebsiteFactory extends Factory
{
    protected $model = Website::class;

    public function definition()
    {
        return [
            'name'       => Str::random(16),
            'account_id' => Account::factory(),
            'template_id'  => Template::factory()
        ];
    }
}
