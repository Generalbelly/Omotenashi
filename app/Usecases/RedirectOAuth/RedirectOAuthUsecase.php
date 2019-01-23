<?php

namespace App\Usecases\RedirectOAuth;

interface RedirectOAuthUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  RedirectOAuthRequestModel  $request
     * @return RedirectOAuthResponseModel
     */
    public function handle(RedirectOAuthRequestModel $request): RedirectOAuthResponseModel;

}