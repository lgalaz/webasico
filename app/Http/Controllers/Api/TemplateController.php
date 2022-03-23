<?php

namespace App\Http\Controllers\Api;

use App\Models\Template;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        return Template::get();
    }
}
