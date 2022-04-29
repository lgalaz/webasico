<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Website;

class ShowWebsiteController extends Controller
{
    public function index(Account $account, Website $website)
    {
        $view = "templates.{$website->template->slug}";

        return view($view);
    }
}
