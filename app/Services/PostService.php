<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Website;

class PostService
{
    public function store(Website $website, array $params) : Post
    {
        $params['website_id'] = $website->website_id;

        $website = Post::withTrashed()
            ->firstOrCreate(
                ['website_id' => $params['website_id'], 'name' => $params['name']],
                $params,
            );

        $website->restore();

        return $website;
    }
}
