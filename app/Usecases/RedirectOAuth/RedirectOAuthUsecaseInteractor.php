<?php

namespace App\Usecases\RedirectOAuth;

use App\Domains\Models\OAuthService;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Exception;

class RedirectOAuthUsecaseInteractor implements RedirectOAuthUsecase {

    public function __construct(
    ){
    }

    /**
     * @param RedirectOAuthRequestModel $request
     * @return RedirectOAuthResponseModel
     * @throws Exception
     */
    public function handle(RedirectOAuthRequestModel $request): RedirectOAuthResponseModel
    {
        switch ($request->service) {
            case OAuthService::GOOGLE_ANALYTICS:
                $provider =
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

        $projectEntity = $this->projectRepository->create([
            'name' => $request->name,
            'domain' => $request->domain,
            'protocol' => $request->protocol,
            'user_id' => $request->userKey,
        ]);

        foreach ($request->whitelistedDomainEntities as $whitelistedDomain) {
            $this->whitelistedDomainRepository->create([
                'domain' => $whitelistedDomain['domain'],
                'protocol' => $whitelistedDomain['protocol'],
                'project_id' => $projectEntity->id,
            ]);
        }

        return new RedirectOAuthResponseModel($projectEntity->toArray());
    }

}