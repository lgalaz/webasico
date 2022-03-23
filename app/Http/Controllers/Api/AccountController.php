<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AccountForm;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function update(Account $account, AccountForm $request): JsonResponse
    {
        $params = request()->only(['name']);

        $account->update($params);

        return response()->json(['account' => $account]);
    }
}
