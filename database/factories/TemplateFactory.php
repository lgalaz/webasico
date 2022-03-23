<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    protected $model = Template::class;

    public function definition()
    {
        return [
            'name'        => Str::random(16),
            'img_src'     => 'https://picsum.photos/200/200/',
            'description' => 'Custom Template'
        ];
    }
}
