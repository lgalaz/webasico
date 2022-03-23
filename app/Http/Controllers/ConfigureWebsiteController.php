<?php

namespace App\Http\Controllers;

use App\Models\Website;

class ConfigureWebsiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function __invoke($account, Website $website)
    {
        return view('websites.configure', compact('website'));
    }
}
