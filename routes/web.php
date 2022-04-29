<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowWebsiteController;

Route::get('/', function () {
    if (app()->environment('development')) {
        if (!Auth::check()) {
            Auth::loginUsingId(2, true);
        }

        return redirect()->route('profile.show');
    }

    return view('welcome');
})->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('users')->group(base_path('routes/web/user.php'));

Route::prefix('me')->group(base_path('routes/web/profile.php'));

Route::prefix('emails')->group(base_path('routes/web/email.php'));

Route::prefix('accounts/{account}/websites')->group(base_path('routes/web/website.php'));

Route::domain('{account:slug}.' . config('app.domain'))
    ->get('{website:slug}', [ShowWebsiteController::class, 'index'])
    ->where([
        'account' => '^[\s\w-]*$',
        'website' => '^[\s\w-]*$',
    ])
    ->name('website.show');
