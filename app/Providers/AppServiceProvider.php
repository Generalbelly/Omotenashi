<?php

namespace App\Providers;

use App\Repositories\User\UserRepositoryContract;
use Illuminate\Support\ServiceProvider;

use Auth0\Login\Contract\Auth0UserRepository;

use App\Domains\Entities\UserEntity;
use App\Domains\Entities\SiteEntity;
use App\Domains\Entities\TutorialEntity;
use App\Domains\Entities\OAuthEntity;

use App\Domains\Entities\Observers\UserEntityObserver;
use App\Domains\Entities\Observers\TutorialEntityObserver;
use App\Domains\Entities\Observers\SiteEntityObserver;
use App\Domains\Entities\Observers\OAuthEntityObserver;

use App\Repositories\User\UserRepository;
use App\Repositories\Site\SiteRepositoryContract;
use App\Repositories\Site\SiteRepository;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Tutorial\TutorialRepository;

use App\Usecases\AddTutorialUsecase\AddTutorialUsecase;
use App\Usecases\AddTutorialUsecase\AddTutorialUsecaseInteractor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        UserEntity::observe(UserEntityObserver::class);
        TutorialEntity::observe(TutorialEntityObserver::class);
        SiteEntity::observe(SiteEntityObserver::class);
        OAuthEntity::observe(OAuthEntityObserver::class);
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
            UserRepositoryContract::class,
            UserRepository::class
        );

        $this->app->bind(
            TutorialRepositoryContract::class,
            TutorialRepository::class
        );

        $this->app->bind(
            SiteRepositoryContract::class,
            SiteRepository::class
        );

        $this->app->bind(
            AddTutorialUsecase::class,
            AddTutorialUsecaseInteractor::class
        );

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
