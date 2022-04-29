<?php

namespace App\Providers;

use App\Models\Template;
use App\Models\Account;
use App\Models\Website;
use App\Observers\TemplateObserver;
use App\Observers\AccountObserver;
use App\Observers\WebsiteObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        } 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Account::observe(AccountObserver::class);
        Template::observe(TemplateObserver::class);
        Website::observe(WebsiteObserver::class);
    }
}
