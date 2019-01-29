<?php

namespace App\Usecases\RedirectOAuth;

use App\Domains\Models\OAuthService;
use Exception;
use App;

class RedirectOAuthUsecaseInteractor implements RedirectOAuthUsecase {

    /**
     * @param RedirectOAuthRequestModel $request
     * @return RedirectOAuthResponseModel
     * @throws Exception
     */
    public function handle(RedirectOAuthRequestModel $request): RedirectOAuthResponseModel
    {
        switch ($request->service) {
            case OAuthService::GOOGLE_ANALYTICS:
                /** @var App\Domains\Models\OAuthProviderGoogle $provider */
                $provider = App::make('App\Domains\Models\OAuthProviderGoogle');
                $params = [
                    'scope' => [
                        'https://www.googleapis.com/auth/analytics',
                        'email'
                    ],
                    'approval_prompt' => 'force'
                ];
                break;
            default:
                throw new Exception('OAuth service not found');
        }

        return new RedirectOAuthResponseModel([
            'url'   => $provider->getAuthorizationUrl($params),
            'state' => $provider->getState(),
        ]);
    }

}