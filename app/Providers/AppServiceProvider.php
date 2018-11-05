<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth0\Login\Contract\Auth0UserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BaseRepositoryContract;
use App\Repositories\User\UserRepositoryContract;

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

use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Usecases\AddTutorial\AddTutorialUsecaseInteractor;

use App\Usecases\ListTutorials\ListTutorialsUsecase;
use App\Usecases\ListTutorials\ListTutorialsUsecaseInteractor;

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
            BaseRepositoryContract::class,
            BaseRepository::class
        );

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

        $this->app->bind(
            ListTutorialsUsecase::class,
            ListTutorialsUsecaseInteractor::class
        );

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
