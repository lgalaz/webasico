<?php

namespace App\Http\Controllers;

class ShowProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function __invoke()
    {
        return view('profile');
    }
}
