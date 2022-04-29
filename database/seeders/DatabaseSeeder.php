<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Utils\ValidatesEnvironment;

class DatabaseSeeder extends Seeder
{
    use ValidatesEnvironment;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->validateRunningEnvironment(['local', 'testing', 'production']);

        $this->call(UsersSeeder::class);
        $this->call(TemplatesSeeder::class);
    }
}
