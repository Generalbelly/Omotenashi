<?php

namespace App\Usecases\DeleteOAuth;

interface DeleteOAuthUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  DeleteOAuthRequestModel  $request
     * @return DeleteOAuthResponseModel
     */
    public function handle(DeleteOAuthRequestModel $request): DeleteOAuthResponseModel;

}