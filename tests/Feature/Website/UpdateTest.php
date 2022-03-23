<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Website;
use Tests\ResetsDatabase;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;

class UpdateTest extends TestCase
{
    use ResetsDatabase;

    protected $url;
    protected $user;
    protected $website;

    protected function setUp() : void
    {
        parent::setUp();

        $this->user    = User::factory()->create();
        $this->website = Website::factory()->create([
            'account_id' => $this->user->account->account_id
        ]);
        $this->url     = route('api.website.update', [
            $this->user->account,
            $this->website
        ]);
    }

    public function test_requires_a_signed_in_user()
    {
        $this->expectException(AuthenticationException::class);

        $this->put($this->url, [])
            ->assertForbidden();
    }

    public function test_can_not_update_website_for_a_different_account()
    {
        $newWebsite       = Website::factory()->make()->toArray();
        $differentAccount = Account::factory()->create();
        $url              = route('api.website.update', [
            $differentAccount,
            $this->website
        ]);

        $this->actingAs($this->user)
            ->put($url, $newWebsite)
            ->assertStatus(Response::HTTP_BAD_REQUEST);

        $this->assertFalse($newWebsite['name'] === $this->website->refresh()->name);
    }

    public function test_can_update()
    {
        $newWebsite = Website::factory()->make()->toArray();

        $this->actingAs($this->user)
            ->put($this->url, $newWebsite)
            ->assertStatus(Response::HTTP_OK);

        $this->assertEquals($newWebsite['name'], $this->website->refresh()->name);
    }
}
