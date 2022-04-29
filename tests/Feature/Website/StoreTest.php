<?php

namespace Tests\Feature\Website;

use App\Models\Account;
use Tests\TestCase;
use App\Models\Website;
use Tests\ResetsDatabase;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;

class StoreTest extends TestCase
{
    use ResetsDatabase;

    protected $url;
    protected $user;

    protected function setUp() : void
    {
        parent::setUp();
        $account = Account::factory()->create();
        $this->user = $account->user;
        $this->url  = route('api.website.store', [$this->user->account]);
    }

    public function test_requires_a_signed_in_user()
    {
        $this->expectException(AuthenticationException::class);

        $this->post($this->url, [])
            ->assertForbidden();
    }

    public function test_it_stores_a_new_website_if_the_name_didnt_exist()
    {
        $newWebsite = Website::factory()->make()->toArray();

        $this->assertDatabaseMissing('websites', ['name' => $newWebsite['name']]);

        $response = $this->actingAs($this->user)
            ->post($this->url, $newWebsite)
            ->assertStatus(Response::HTTP_OK);

        $response = json_decode($response->getContent(), true);

        $this->assertDatabaseHas('websites', [
            'website_id' => $response['website']['website_id'],
            'name'       => $newWebsite['name'],
        ]);
    }
}
