<?php

namespace App\Usecases\AddOAuth;

interface AddOAuthUsecase {

    /**
     * @param AddOAuthRequestModel $request
     * @return AddOAuthResponseModel
     */
    public function handle(AddOAuthRequestModel $request): AddOAuthResponseModel;

}