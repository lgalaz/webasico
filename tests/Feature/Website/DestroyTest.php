<?php

namespace Tests\Feature\Website;

use Tests\TestCase;
use App\Models\User;
use App\Models\Website;
use Tests\ResetsDatabase;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class DestroyTest extends TestCase
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
        $this->url     = route('api.website.destroy', [
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

    public function test_can_not_delete_last_website_for_an_account()
    {
        $this->expectException(ValidationException::class);

        $this->actingAs($this->user)
            ->delete($this->url);

        $this->assertNull($this->website->refresh()->deleted_at);
    }

    public function test_soft_deletes_a_website()
    {
        // Add a new website so that it has more than one website on the account.
        Website::factory()->create([
            'account_id' => $this->user->account->account_id
        ]);

        // Delete the first website we created in the setUp.
        $this->actingAs($this->user)
            ->delete($this->url)
            ->assertStatus(Response::HTTP_OK);

        $this->assertNotNull($this->website->refresh()->deleted_at);
    }
}
