<?php

namespace App\Usecases\StoreGoogleAnalyticsAccounts;

use App;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Domains\Models\OAuthService;
use App\Domains\Models\GoogleApiClient;
use Google_Service_Analytics;
use Exception;
use Log;

class StoreGoogleAnalyticsAccountsUsecaseInteractor implements StoreGoogleAnalyticsAccountsUsecase
{
    /** @var OAuthRepositoryContract */
    private $oauthRepository;
    /** @var App\Domains\Models\GoogleApiClient */
    private $client;

    public function __construct(
        OAuthRepositoryContract $oauthRepository,
        GoogleApiClient $client
    ){
        $this->oauthRepository = $oauthRepository;
        $this->client = $client;
    }

    /**
     * @param StoreGoogleAnalyticsAccountsRequestModel $request
     * @return StoreGoogleAnalyticsAccountsResponseModel
     * @throws Exception
     */
    public function handle(StoreGoogleAnalyticsAccountsRequestModel $request): StoreGoogleAnalyticsAccountsResponseModel
    {
        /** @var App\Domains\Entities\OAuthEntity $oauthEntity */
        $oauthEntity = $this->oauthRepository->where([
            'project_id' => $request->project_id,
            'service' => OAuthService::GOOGLE_ANALYTICS,
        ])->firstOrFail();

        /** @var \App\Domains\Models\OAuthProviderGoogle $provider */
        $provider = App::make('App\Domains\Models\OAuthProviderGoogle');
        $grant = App::make('App\Domains\Models\OAuthRefreshToken');

        $accessToken = $provider->getAccessToken($grant, [
            'refresh_token' => $oauthEntity->getAttribute('refreshToken')
        ]);

        $this->client->setAccessToken($accessToken);

        $analytics = new Google_Service_Analytics($this->client);

        try {
            $accounts = $analytics->management_accounts->listManagementAccounts();
            Log::error(print_r($accounts, true));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        return new StoreGoogleAnalyticsAccountsResponseModel($oauthEntity->toArray());
    }

}