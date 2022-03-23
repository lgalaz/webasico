<?php

use App\Http\Controllers\ShowProfileController;

Route::get('/', ShowProfileController::class)->name('profile.show');
