<?php

namespace App\Usecases\AddOAuth;

interface AddOAuthUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  DeleteOAuthRequestModel  $request
     * @return AddOAuthResponseModel
     */
    public function handle(DeleteOAuthRequestModel $request): AddOAuthResponseModel;

}