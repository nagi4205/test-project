<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Presenters\MessagePresenter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MessagePresenter::class, function ($app) {
            return new MessagePresenter();
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
