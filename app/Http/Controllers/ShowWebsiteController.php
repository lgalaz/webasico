<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Website;

class ShowWebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function __invoke(Account $account, Website $website)
    {
        dump('acc', $account, $website);

        return view('home');
    }
}
