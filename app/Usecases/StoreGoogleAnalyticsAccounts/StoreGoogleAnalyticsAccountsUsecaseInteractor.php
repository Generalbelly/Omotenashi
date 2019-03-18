<?php

namespace App\Usecases\StoreGoogleAnalyticsAccounts;

use App;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Domains\Models\OAuth\OAuthService;
use Exception;
use Log;

class StoreGoogleAnalyticsAccountsUsecaseInteractor implements StoreGoogleAnalyticsAccountsUsecase
{
    /** @var OAuthRepositoryContract */
    private $oauthRepository;

    public function __construct(
        OAuthRepositoryContract $oauthRepository
    ){
        $this->oauthRepository = $oauthRepository;
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

        if ($oauthEntity->getAttribute('expired_at')->getTimestamp() < time()) {
            /** @var \App\Domains\Models\OAuth\OAuthProviderGoogle $provider */
            $provider = App::make('App\Domains\Models\OAuth\OAuthProviderGoogle');
            $grant = App::make('App\Domains\Models\OAuth\OAuthRefreshToken');
            $token = $provider->getAccessToken($grant, [
                'refresh_token' => $oauthEntity->getAttribute('refresh_token')
            ]);
            $oauthEntity = $this->oauthRepository->update([
                'access_token' => $token,
                'expired_at' => $token->getExpires(),
            ], $oauthEntity->getAttribute('id'));
        }

        /** @var \App\Domains\Models\GoogleAnalyticsClient $analytics */
        $analytics = App::make('App\Domains\Models\GoogleAnalyticsClient');

        try {
            $accounts = $analytics->listAccounts();
            Log::error(print_r($accounts, true));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        return new StoreGoogleAnalyticsAccountsResponseModel($oauthEntity->toArray());
    }

}