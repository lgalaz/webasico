<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplatesSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating sample templates.');
        Template::updateOrCreate(
            [ 'name' => 'custom' ],
            [
                'slug'        => 'custom',
                'description' => 'Use your own custom template',
                'img_src'     => 'https://picsum.photos/200/200/?image=25',
            ]
        );
        
        Template::updateOrCreate(
            ['slug' => 'simple_blog'],
            [
                'description' => 'Create a blog with a minimalist design.',
                'img_src'     => 'https://picsum.photos/200/200/',
                'name' => 'Simple Blog',
            ]
        );
    }
}
