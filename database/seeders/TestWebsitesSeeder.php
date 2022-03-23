<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Template;
use App\Models\Account;
use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestWebsitesSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Creating site mysite if it does not exist.');

        $mySiteUser = User::updateOrCreate(
            ['email' => 'user@mysite.com'],
            [
                'name'              => 'MySite',
                'password'          => Hash::make('P@$$w0rdSite'),
                'email_verified_at' => now(),
            ]
        );

        $myAccount = Account::where('user_id', '=', $mySiteUser->user_id)
            ->first();

        $blogTemplateId = Template::where('slug', '=', 'simple_blog')->firstOrFail()->template_id;
        Website::updateOrCreate(
            ['name' => 'My Site'],
            ['account_id' => $myAccount->account_id, 'template_id' => $blogTemplateId],
        );
    }
}
