<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth0\Login\Contract\Auth0UserRepository;
use App\Entities\User;
use App\Entities\Observers\UserObserver;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Auth0UserRepository::class,
            UserRepository::class
        );
    }
}
