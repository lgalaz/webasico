<?php

use App\Http\Controllers\Api\AccountController;

Route::put('/{account}', [AccountController::class, 'update'])->name('api.account.update');
