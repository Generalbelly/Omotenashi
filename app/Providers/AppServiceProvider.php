<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth0\Login\Contract\Auth0UserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\BaseRepositoryContract;
use App\Repositories\User\UserRepositoryContract;

use App\Domains\Entities\UserEntity;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Domains\Entities\OAuthEntity;

use App\Domains\Entities\Observers\UserEntityObserver;
use App\Domains\Entities\Observers\TutorialEntityObserver;
use App\Domains\Entities\Observers\ProjectEntityObserver;
use App\Domains\Entities\Observers\OAuthEntityObserver;

use App\Repositories\User\UserRepository;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Tutorial\TutorialRepository;

use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Usecases\AddTutorial\AddTutorialUsecaseInteractor;

use App\Usecases\UpdateTutorial\UpdateTutorialUsecase;
use App\Usecases\UpdateTutorial\UpdateTutorialUsecaseInteractor;

use App\Usecases\DeleteTutorial\DeleteTutorialUsecase;
use App\Usecases\DeleteTutorial\DeleteTutorialUsecaseInteractor;

use App\Usecases\ListTutorials\ListTutorialsUsecase;
use App\Usecases\ListTutorials\ListTutorialsUsecaseInteractor;

use App\Usecases\ListProjects\ListProjectsUsecase;
use App\Usecases\ListProjects\ListProjectsUsecaseInteractor;

use App\Usecases\AddProject\AddProjectUsecase;
use App\Usecases\AddProject\AddProjectUsecaseInteractor;

use App\Usecases\GetProject\GetProjectUsecase;
use App\Usecases\GetProject\GetProjectUsecaseInteractor;

use App\Usecases\UpdateProject\UpdateProjectUsecase;
use App\Usecases\UpdateProject\UpdateProjectUsecaseInteractor;


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
        ProjectEntity::observe(ProjectEntityObserver::class);
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
            ProjectRepositoryContract::class,
            ProjectRepository::class
        );

        $this->app->bind(
            ListTutorialsUsecase::class,
            ListTutorialsUsecaseInteractor::class
        );

        $this->app->bind(
            AddTutorialUsecase::class,
            AddTutorialUsecaseInteractor::class
        );

        $this->app->bind(
            UpdateTutorialUsecase::class,
            UpdateTutorialUsecaseInteractor::class
        );

        $this->app->bind(
            DeleteTutorialUsecase::class,
            DeleteTutorialUsecaseInteractor::class
        );

        $this->app->bind(
            ListProjectsUsecase::class,
            ListProjectsUsecaseInteractor::class
        );

        $this->app->bind(
            AddProjectUsecase::class,
            AddProjectUsecaseInteractor::class
        );

        $this->app->bind(
            GetProjectUsecase::class,
            GetProjectUsecaseInteractor::class
        );

        $this->app->bind(
            UpdateProjectUsecase::class,
            UpdateProjectUsecaseInteractor::class
        );

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
