<?php

use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, '@index'])->name('user.index');
