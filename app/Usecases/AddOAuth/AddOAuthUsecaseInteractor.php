<?php

namespace App\Usecases\AddOAuth;

use Exception;
use App;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Domains\Models\OAuthService;
use Log;

class AddOAuthUsecaseInteractor implements AddOAuthUsecase
{
    /** @var OAuthRepositoryContract */
    private $oauthRepository;

    public function __construct(
        OAuthRepositoryContract $oauthRepository
    ){
        $this->oauthRepository = $oauthRepository;
    }

    /**
     * @param AddOAuthRequestModel $request
     * @return AddOAuthResponseModel
     * @throws Exception
     */
    public function handle(AddOAuthRequestModel $request): AddOAuthResponseModel
    {
        switch ($request->service) {
            case OAuthService::GOOGLE_ANALYTICS:
                /** @var \App\Domains\Models\OAuthProviderGoogle $provider */
                $provider = App::make('App\Domains\Models\OAuthProviderGoogle');

                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $request->code,
                ]);
                $refreshToken = $token->getRefreshToken();
                $user = $provider->getResourceOwner($token);
                $email = $user->getEmail();

                /** @var App\Domains\Entities\OAuthEntity $oauthEntity */
                $oauthEntity = $this->oauthRepository->where([
                    'email' => $email,
                    'service' => $request->service,
                    'project_id' => $request->project_id,
                ])->first();

                if (!$oauthEntity) {
                    $oauthEntity = $this->oauthRepository->where([
                        'email' => $email,
                        'service' => $request->service,
                        'project_id' => $request->project_id,
                    ])->withTrashed()->first();

                    if ($oauthEntity) {
                        $oauthEntity->restore();
                    }
                }

                if (!$oauthEntity) {
                    if (!$refreshToken) {
                        throw new Exception(sprintf('Someone has already connected this account %s', $email));
                    }
                    $oauthEntity = $this->oauthRepository->create([
                        'service' => $request->service,
                        'email' => $email,
                        'refresh_token' => $refreshToken,
                        'project_id' => $request->project_id,
                    ]);
                }

                $grant = App::make('App\Domains\Models\OAuthRefreshToken');
                $accessToken = $provider->getAccessToken($grant, [
                    'refresh_token' => $oauthEntity->getAttribute('refresh_token'),
                ]);

                $client = App::make('App\Domains\Models\GoogleApiClient');
                $client->setAccessToken($accessToken);
                $analytics = new Google_Service_Analytics($this->client);

                try {
                    $accounts = $analytics->management_accounts->listManagementAccounts();
                    Log::error(print_r($accounts, true));
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    throw $e;
                }
                break;
            default:
                throw new Exception('OAuth service not found');
        }
        return new AddOAuthResponseModel($oauthEntity->toArray());
    }

}