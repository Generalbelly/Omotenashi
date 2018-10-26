<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth0\Login\Contract\Auth0UserRepository;

use App\Entities\User;
use App\Entities\Site;
use App\Entities\Tutorial;
use App\Entities\GAOAuth;

use App\Entities\Observers\UserObserver;
use App\Entities\Observers\TutorialObserver;
use App\Entities\Observers\SiteObserver;
use App\Entities\Observers\GAOAuthObserver;

use App\Repositories\User\UserRepository;
use App\Repositories\Site\SiteRepositoryContract;
use App\Repositories\Tutorial\TutorialRepository;

use App\Usecases\CreateTutorialUsecase\CreateTutorialUsecase;
use App\Usecases\CreateTutorialUsecase\CreateTutorialUsecaseInteractor;

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
        Tutorial::observe(TutorialObserver::class);
        Site::observe(SiteObserver::class);
        GAOAuth::observe(GAOAuthObserver::class);
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

        $this->app->bind(
            SiteRepositoryContract::class,
            TutorialRepository::class
        );

        $this->app->bind(
            CreateTutorialUsecase::class,
            CreateTutorialUsecaseInteractor::class
        );

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
