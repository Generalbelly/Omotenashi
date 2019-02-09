<?php

namespace App\Usecases\DeleteOAuth;

use Exception;
use App;
use App\Repositories\OAuth\OAuthRepositoryContract;
use App\Domains\Models\OAuthService;
use Log;

class DeleteOAuthUsecaseInteractor implements DeleteOAuthUsecase
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
     * @return DeleteOAuthResponseModel
     * @throws Exception
     */
    public function handle(DeleteOAuthRequestModel $request): DeleteOAuthResponseModel
    {
        $oauthEntity = $this->oauthRepository->delete($request->id);
        return new DeleteOAuthResponseModel($oauthEntity->toArray());
    }

}