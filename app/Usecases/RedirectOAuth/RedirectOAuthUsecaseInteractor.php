<?php

namespace App\Usecases\RedirectOAuth;

use App\Domains\Models\OAuth\OAuthService;
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
                /** @var \App\Domains\Models\OAuth\OAuthProviderGoogle $provider */
                $provider = App::make('App\Domains\Models\OAuth\OAuthProviderGoogle');
                $params = [
                    'scope' => [
                        'https://www.googleapis.com/auth/analytics',
                        'https://www.googleapis.com/auth/analytics.edit',
                        'email'
                    ],
                    'prompt' => 'consent',
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