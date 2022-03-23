<?php

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ConfigureWebsiteController;

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');

Route::get('/{website}/configure', ConfigureWebsiteController::class)->name('website.configure');
