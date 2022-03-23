<?php

namespace Tests\Feature\Account;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use Tests\ResetsDatabase;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

class UpdateTest extends TestCase
{
    use ResetsDatabase;

    protected $url;
    protected $user;

    protected function setUp() : void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->url  = route('api.account.update', [$this->user->account]);
    }

    public function test_requires_a_signed_in_user()
    {
        $this->expectException(AuthenticationException::class);

        $this->put($this->url, [])
            ->assertForbidden();
    }

    public function test_can_not_update_account_that_is_not_for_the_signed_in_user()
    {
        $this->expectException(ValidationException::class);

        $accountToUpdate = Account::factory()->create();
        $url             = route('api.account.update', [$accountToUpdate]);
        $newAccount      = Account::factory()->make()->toArray();
        $expectedName    = $accountToUpdate->name;

        $this->actingAs($this->user)
            ->put($url, $newAccount);

        $this->assertTrue($expectedName === $accountToUpdate->refresh()->name);
    }

    public function test_can_update()
    {
        $newAccount = Account::factory()->make()->toArray();

        $this->actingAs($this->user)
            ->put($this->url, $newAccount)
            ->assertStatus(Response::HTTP_OK);

        $account = $this->user->account->fresh();

        $this->assertEquals($newAccount['name'], $account->name);
    }
}
