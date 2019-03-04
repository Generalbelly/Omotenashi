<?php

namespace App\Usecases\ListGoogleAnalyticsAccounts;

use App\Domains\Entities\OAuthEntity;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App;

class ListGoogleAnalyticsAccountsUsecaseInteractor implements ListGoogleAnalyticsAccountsUsecase {

    /**
     * @var OAuthRepositoryContract
     */
    private $oauthRepository;

    /**
     * ListGoogleAnalyticsAccountsUsecaseInteractor constructor.
     * @param OAuthRepositoryContract $oauthRepository
     */
    public function __construct(
        OAuthRepositoryContract $oauthRepository
    ){
        $this->oauthRepository = $oauthRepository;
    }

    public function handle(ListGoogleAnalyticsAccountsRequestModel $request): ListGoogleAnalyticsAccountsResponseModel
    {
        /** @var OAuthEntity $oauthEntity */
        $oauthEntity = $this->oauthRepository->where(
            'project_id',
            '=',
            $request->project_id
        )->firstOrFail();

        if ($oauthEntity->getAttribute('expired_at')->getTimestamp() < time()) {
            /** @var App\Domains\Models\OAuth\OAuthProviderGoogle $provider */
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

        /** @var App\Domains\Models\GoogleAnalyticsClient $client */
        $client = App::make('App\Domains\Models\GoogleAnalyticsClient');
        $client->setAccessToken($oauthEntity->getAttribute('access_token'));
        $accounts = $client->listAccountSummaries();

        return new ListGoogleAnalyticsAccountsResponseModel([
            'project_id' => $request->project_id,
            'accounts' => $accounts,
        ]);
    }
}