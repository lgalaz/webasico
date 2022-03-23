<?php

namespace Tests\Feature\Post;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Website;

class IndexTest extends TestCase
{
    protected $posts;

    protected function setUp() : void
    {
        parent::setUp();

        $user    = User::factory()->create();
        $website = Website::factory()->create([
            'account_id' => $this->user->account->account_id
        ]);

        // $posts = Post::factory()->create();

        // $this->url     = route('api.website.destroy', [
        //     $this->user->account,
        //     $this->website
        // ]);
    }
}
