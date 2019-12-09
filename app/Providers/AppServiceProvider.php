<?php

namespace App\Providers;

use App\Services\AdwordsDataService;
use App\Services\Interfaces\AdwordsDataServiceInterface;
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
        $this->app->bind(AdwordsDataServiceInterface::class, AdwordsDataService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
