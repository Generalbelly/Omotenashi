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
     * @param DeleteOAuthRequestModel $request
     * @return AddOAuthResponseModel
     * @throws Exception
     */
    public function handle(DeleteOAuthRequestModel $request): AddOAuthResponseModel
    {
        switch ($request->service) {
            case OAuthService::GOOGLE_ANALYTICS:
                /** @var \App\Domains\Models\OAuthProviderGoogle $provider */
                $provider = App::make('App\Domains\Models\OAuthProviderGoogle');

                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $request->code,
                ]);
                $refreshToken = $token->getRefreshToken();
                $access_token = $token->getToken();
                $user = $provider->getResourceOwner($token);
                $email = $user->getEmail();
                $oauthEntity = $this->oauthRepository->create([
                    'service' => $request->service,
                    'email' => $email,
                    'refresh_token' => $refreshToken,
                    'access_token'  => $access_token,
                    'project_id' => $request->project_id,
                ]);
                break;
            default:
                throw new Exception('OAuth service not found');
        }
        return new AddOAuthResponseModel($oauthEntity->toArray());
    }

}