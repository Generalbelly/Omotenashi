<?php

namespace App\Providers;



use App\Domains\Entities\GoogleAnalyticsPropertyEntity;
use App\Domains\Entities\Observers\GoogleAnalyticsPropertyEntityObserver;
use App\Usecases\AddOAuth\AddOAuthUsecase;
use App\Usecases\AddOAuth\AddOAuthUsecaseInteractor;
use App\Usecases\DeleteOAuth\DeleteOAuthUsecase;
use App\Usecases\DeleteOAuth\DeleteOAuthUsecaseInteractor;
use App\Usecases\RedirectOAuth\RedirectOAuthUsecase;
use App\Usecases\RedirectOAuth\RedirectOAuthUsecaseInteractor;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


use App\Repositories\BaseRepositoryContract;
use App\Repositories\BaseRepository;

use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepository;

use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Repositories\OAuth\OAuthRepository;

use App\Repositories\User\UserRepositoryContract;
use App\Repositories\User\UserRepository;
use Auth0\Login\Contract\Auth0UserRepository;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\Project\ProjectRepository;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Tutorial\TutorialRepository;

use App\Repositories\GoogleAnalyticsProperty\GoogleAnalyticsPropertyRepositoryContract;
use App\Repositories\GoogleAnalyticsProperty\GoogleAnalyticsPropertyRepository;

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

use App\Domains\Models\OAuth\OAuthProviderGoogle as IOAuthProviderGoogle;
use League\OAuth2\Client\Provider\Google;

use App\Domains\Models\OAuth\OAuthAccessToken as IOAuthAccessToken;
use League\OAuth2\Client\Token\AccessToken;

use App\Domains\Models\OAuth\OAuthRefreshToken as IRefreshToken;
use League\OAuth2\Client\Grant\RefreshToken;

use App\Domains\Models\GoogleAnalyticsClient as IGoogleAnalyticsClient;
use App\Externals\Google\GoogleAnalyticsClient;

use App\Usecases\ListGoogleAnalyticsAccounts\ListGoogleAnalyticsAccountsUsecase;
use App\Usecases\ListGoogleAnalyticsAccounts\ListGoogleAnalyticsAccountsUsecaseInteractor;

use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 動作環境がlocalとtestingの場合はSQLを全てlogする
        if (env('APP_ENV') === 'local') {
            \DB::listen(function ($query) {
                $sql = $query->sql;
                for ($i = 0; $i < count($query->bindings); $i++) {
                    $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
                }
                \Log::info($sql);
            });
        }

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
        GoogleAnalyticsPropertyEntity::observe(GoogleAnalyticsPropertyEntityObserver::class);

        Validator::extend(
            'uuid',
            function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^[a-f0-9]{8}\-[a-f0-9]{4}\-4[a-f0-9]{3}\-(8|9|a|b)[a-f0-9]{3}\-[a-f0-9]{12}$/', $value);
            }
        );

        Validator::extend(
            'domain',
            function ($attribute, $value, $parameters, $validator) {
                $localhostCheck = preg_match('/^(https?:\/\/)?localhost$/', $value);
                if ($localhostCheck) return true;
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
            OAuthRepositoryContract::class,
            OAuthRepository::class
        );

        $this->app->bind(
            GoogleAnalyticsPropertyRepositoryContract::class,
            GoogleAnalyticsPropertyRepository::class
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

        $this->app->bind(
            RedirectOAuthUsecase::class,
            RedirectOAuthUsecaseInteractor::class
        );

        $this->app->bind(
            AddOAuthUsecase::class,
            AddOAuthUsecaseInteractor::class
        );

        $this->app->bind(
            DeleteOAuthUsecase::class,
            DeleteOAuthUsecaseInteractor::class
        );

        $this->app->bind(
            IOAuthAccessToken::class,
            AccessToken::class
        );

        $this->app->bind(
            IRefreshToken::class,
            RefreshToken::class
        );

        $this->app->bind(
            ListGoogleAnalyticsAccountsUsecase::class,
            ListGoogleAnalyticsAccountsUsecaseInteractor::class
        );

        $this->app->bind(
            IGoogleAnalyticsClient::class,
            GoogleAnalyticsClient::class
        );

        $this->app->bind(IOAuthProviderGoogle::class, function($app){
            return new Google([
                'clientId'     => config('services.google.clientId'),
                'clientSecret' => config('services.google.clientSecret'),
                'redirectUri'  => config('services.google.redirectUri'),
                'accessType'   => 'offline',
            ]);
        });

//        $this->app->bind(IGoogleAnalyticsClient::class, function($app){
//            $client = new GoogleAnalyticsClient();
//            return $client;
//        });


        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
