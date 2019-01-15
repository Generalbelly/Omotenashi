<?php

namespace App\Usecases\AddOAuth;

interface AddOAuthUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  AddOAuthRequestModel  $request
     * @return AddOAuthResponseModel
     */
    public function handle(AddOAuthRequestModel $request): AddOAuthResponseModel;

}