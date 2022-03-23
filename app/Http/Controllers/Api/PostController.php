<?php

namespace App\Http\Controllers\Api;

use App\Models\Website;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WebsiteForm;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $service = null;

    public function __construct(PostService $service)
    {
        $this->middleware(['auth', 'verified']);

        $this->service = $service;
    }

    public function index(Website $website)
    {
        //Todo: Unit tests for index
        return $website->posts;
    }

    public function store(Website $website, WebsiteForm $request): JsonResponse
    {
        //Todo: Unit tests for store
        $params = request()->only(['content', 'excertp', 'name', 'title']);

        $website = $this->service->store($website, $params);

        return response()->json(['website' => $website]);
    }
}
