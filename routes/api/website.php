<?php

use App\Http\Controllers\Api\WebsiteController;

Route::get('/', [WebsiteController::class, 'index'])->name('api.website.index');
Route::post('/', [WebsiteController::class, 'store'])->name('api.website.store');
Route::put('/{website}', [WebsiteController::class, 'update'])->name('api.website.update');
Route::delete('/{website}', [WebsiteController::class, 'destroy'])->name('api.website.destroy');
