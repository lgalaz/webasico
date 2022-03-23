<?php

use App\Http\Controllers\EmailController;

Route::get('/test', [EmailController::class, 'test'])->name('email.test');
