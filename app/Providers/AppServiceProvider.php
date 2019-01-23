<?php

namespace App\Providers;



use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


use App\Repositories\BaseRepositoryContract;
use App\Repositories\BaseRepository;

use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepository;

use App\Repositories\User\UserRepositoryContract;
use App\Repositories\User\UserRepository;
use Auth0\Login\Contract\Auth0UserRepository;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\Project\ProjectRepository;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Tutorial\TutorialRepository;

use App\Domains\Entities\UserEntity;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Domains\Entities\OAuthEntity;
use App\Domains\Entities\WhitelistedDomainEntity;

use App\Domains\Entities\Observers\UserEntityObserver;
use App\Domains\Entities\Observers\TutorialEntityObserver;
use App\Domains\Entities\Observers\ProjectEntityObserver;
use App\Domains\Entities\Observers\OAuthEntityObserver;
use App\Domains\Entities\Observers\WhitelistedDomainEntityObserver;

use App\Usecases\ListTutorials\ListTutorialsUsecase;
use App\Usecases\ListTutorials\ListTutorialsUsecaseInteractor;

use App\Usecases\GetTutorial\GetTutorialUsecase;
use App\Usecases\GetTutorial\GetTutorialUsecaseInteractor;

use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Usecases\AddTutorial\AddTutorialUsecaseInteractor;

use App\Usecases\UpdateTutorial\UpdateTutorialUsecase;
use App\Usecases\UpdateTutorial\UpdateTutorialUsecaseInteractor;

use App\Usecases\DeleteTutorial\DeleteTutorialUsecase;
use App\Usecases\DeleteTutorial\DeleteTutorialUsecaseInteractor;

use App\Usecases\ListProjects\ListProjectsUsecase;
use App\Usecases\ListProjects\ListProjectsUsecaseInteractor;

use App\Usecases\AddProject\AddProjectUsecase;
use App\Usecases\AddProject\AddProjectUsecaseInteractor;

use App\Usecases\GetProject\GetProjectUsecase;
use App\Usecases\GetProject\GetProjectUsecaseInteractor;

use App\Usecases\UpdateProject\UpdateProjectUsecase;
use App\Usecases\UpdateProject\UpdateProjectUsecaseInteractor;

use App\Usecases\DeleteProject\DeleteProjectUsecase;
use App\Usecases\DeleteProject\DeleteProjectUsecaseInteractor;

use League\OAuth2\Client\Provider\Google;
use App\Domains\Models\OAuthProviderGoogle;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 動作環境がstagingとproductionの場合はSSLを強制する
        if (env('APP_ENV') === 'staging' || env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }

        // https://github.com/auth0/auth0-PHP/issues/56
        \Firebase\JWT\JWT::$leeway = 30;

        UserEntity::observe(UserEntityObserver::class);
        TutorialEntity::observe(TutorialEntityObserver::class);
        ProjectEntity::observe(ProjectEntityObserver::class);
        OAuthEntity::observe(OAuthEntityObserver::class);
        WhitelistedDomainEntity::observe(WhitelistedDomainEntityObserver::class);

        Validator::extend(
            'uuid',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/', $value);
            }
        );

        Validator::extend(
            'domain',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^(https?:\/\/)?(([A-Za-z0-9][A-Za-z0-9\-]{1,61}[A-Za-z0-9]|[A-Za-z0-9]{1,63})\.)+[A-Za-z]+$/', $value);
            }
        );
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
            WhitelistedDomainRepositoryContract::class,
            WhitelistedDomainRepository::class
        );

        $this->app->bind(
            ListTutorialsUsecase::class,
            ListTutorialsUsecaseInteractor::class
        );

        $this->app->bind(
            GetTutorialUsecase::class,
            GetTutorialUsecaseInteractor::class
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

        $this->app->bind(
            DeleteProjectUsecase::class,
            DeleteProjectUsecaseInteractor::class
        );

        $this->app->bind(OAuthProviderGoogle::class, function($app){
            return new Google([
                'clientId'     => env('GOOGLE_ANALYTICS_CLIENT_ID'),
                'clientSecret' => env('GOOGLE_ANALYTICS_CLIENT_SECRET'),
                'redirectUri'  => env('GOOGLE_ANALYTICS_CLIENT_REDIRECT_URL'),
                'accessType'   => 'offline',
            ]);
        });


        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
