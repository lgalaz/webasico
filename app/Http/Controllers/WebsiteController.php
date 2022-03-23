<?php

namespace App\Http\Controllers;

use App\Models\Account;

class WebsiteController extends Controller
{
    public function index(Account $account)
    {
        // we are not eager loading websites on the account with route model binding.
        // so we have to lazy load it.
        $websites = $account->websites;

        return view('websites.index', compact('account', 'websites'));
    }
}
