<?php

namespace Tests\Unit\Website\Service;

use Tests\TestCase;
use App\Models\Account;
use App\Models\Website;
use Tests\ResetsDatabase;
use App\Services\WebsiteService;

class UpdateTest extends TestCase
{
    use ResetsDatabase;

    protected $service = null;

    public function setUp() : void
    {
        parent::setUp();

        $this->service = app()->make(WebsiteService::class);
    }

    public function test_if_trashed_exists_for_the_same_account_it_restores_trashed_and_deletes_current()
    {
        $account  = Account::factory()->create();
        $existing = Website::factory()->count(2)->create(['account_id' => $account->account_id]);
        $trashed  = $existing[0];
        $trashed->delete();

        $current      = Website::factory()->create(['account_id'=> $account->account_id]);
        $newValues    = ['name'=> $trashed->name];
        $expectedName = $current->name;

        $this->service->update($current, $newValues);

        $current->refresh();
        $this->assertEquals($expectedName, $current->name);
        $this->assertNull($trashed->refresh()->deleted_at);
        $this->assertNotNull($current->deleted_at);
    }
}
