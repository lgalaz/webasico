<?php

namespace Tests\Unit\Website\Service;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Website;
use Tests\ResetsDatabase;
use App\Services\WebsiteService;

class StoreTest extends TestCase
{
    use ResetsDatabase;

    protected $service = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->service = app()->make(WebsiteService::class);
    }

    public function test_it_restores_deleted_websites_when_name_exists_for_that_account()
    {
        $account  = Account::factory()->create();
        $websites = Website::factory()->count(2)->create([
            'account_id' => $account->account_id
        ]);

        $firstWebsite = $websites->first();
        $firstWebsite->delete();

        $newWebsite = Website::factory()
            ->make([
                'account_id' => $account->account_id,
                'name'       => $firstWebsite->name
            ])
            ->toArray();

        $storedWebsite = $this->service->store($account, $newWebsite);

        $this->assertEquals($storedWebsite->website_id, $firstWebsite->website_id);
        $this->assertEquals($storedWebsite->name, $firstWebsite->name);
        $this->assertNull($firstWebsite->refresh()->deleted_at);
    }

    public function test_it_can_create_a_new_website_when_name_exists_for_a_different_account()
    {
        $account  = Account::factory()->create();
        $user = $account->user;
        $websites = Website::factory()->count(2)->create([
            'account_id' => $account->account_id
        ]);

        $firstWebsite = $websites->first();
        $firstWebsite->delete();

        $newAccount = Account::factory()->create([
            'user_id' => $user->user_id,
        ]);

        $newWebsite = Website::factory()
            ->make(['name' => $firstWebsite->name])
            ->toArray();

        $storedWebsite = $this->service->store($newAccount, $newWebsite);

        $this->assertFalse($storedWebsite->website_id === $firstWebsite->website_id);
        $this->assertNotNull($firstWebsite->refresh()->deleted_at);
    }
}
