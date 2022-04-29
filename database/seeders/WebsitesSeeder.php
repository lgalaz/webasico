<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Template;
use App\Models\Account;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Utils\ValidatesEnvironment;

class WebsitesSeeder extends Seeder
{
    use ValidatesEnvironment;
    
    public function run()
    {
        $this->validateRunningEnvironment(['local']);

        $this->command->info('Creating site mysite if it does not exist.');

        $mySiteUser = User::updateOrCreate(
            ['email' => 'user@mysite.com'],
            [
                'name'              => 'MySite',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $myAccount = Account::updateOrCreate(
            [ 'user_id' => $mySiteUser->user_id ], 
            [ 'name'    => 'My Site' ]
        );

        $blogTemplateId = Template::where('slug', '=', 'simple-blog')->firstOrFail()->template_id;
        Website::updateOrCreate(
            ['name' => 'My Site'],
            ['account_id' => $myAccount->account_id, 'template_id' => $blogTemplateId],
        );
    }
}
