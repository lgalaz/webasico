<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Website;
use App\Models\Template;
use Illuminate\Http\Response;
use App\Services\WebsiteService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\WebsiteForm;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    protected $service = null;

    public function __construct(WebsiteService $service)
    {
        $this->middleware(['auth', 'verified']);

        $this->service = $service;
    }

    public function index(Account $account)
    {
        return $account->websites;
    }

    public function store(Account $account, WebsiteForm $request): JsonResponse
    {
        $params = request()->only(['name']);
        $params['template_id'] = Template::where('slug', '=', 'custom')->firstOrFail()->template_id;

        $website = $this->service->store($account, $params);

        return response()->json(['website' => $website]);
    }

    public function update(Account $account, Website $website, WebsiteForm $request): JsonResponse
    {
        if (intval($website->account_id) !== intval($account->account_id)) {
            return response()->json([
                'message' => 'Invalid website'
            ], Response::HTTP_BAD_REQUEST);
        }

        $params = request()->only(['name', 'template_id']);

        $website = $this->service->update($website, $params);

        return response()->json(['website' => $website]);
    }

    public function destroy(Account $account, Website $website)
    {
        $website->delete();
    }
}
