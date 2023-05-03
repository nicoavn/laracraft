<?php

namespace App\Providers;

use App\Services\BattleConfiguration;
use App\Services\BattleService;
use App\Services\Impl\SimpleBattleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BattleService::class, function ($app) {
            return new SimpleBattleService(new BattleConfiguration());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
