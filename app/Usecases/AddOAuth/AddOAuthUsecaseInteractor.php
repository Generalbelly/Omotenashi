<?php

namespace App\Usecases\AddOAuth;

use Exception;
use App;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Domains\Models\OAuth\OAuthService;
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
                /** @var \App\Domains\Models\OAuth\OAuthProviderGoogle $provider */
                $provider = App::make('App\Domains\Models\OAuth\OAuthProviderGoogle');

                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $request->code,
                ]);
                $refreshToken = $accessToken->getRefreshToken();
                $ownerDetails = $provider->getResourceOwner($accessToken);
                $email = $ownerDetails->getEmail();

                $where = [
                    'email' => $email,
                    'service' => $request->service,
                    'project_id' => $request->project_id,
                ];
                /** @var App\Domains\Entities\OAuthEntity $oauthEntity */
                $oauthEntity = $this->oauthRepository->where($where)->first();

                if (!$oauthEntity) {
                    $oauthEntity = $this->oauthRepository->where($where)->withTrashed()->first();

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
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                        'expired_at' => $accessToken->getExpires(),
                        'project_id' => $request->project_id,
                    ]);
                }
                break;
            default:
                throw new Exception('OAuth service not found');
        }
        return new AddOAuthResponseModel($oauthEntity->toArray());
    }

}