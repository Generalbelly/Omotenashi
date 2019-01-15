<?php

namespace App\Usecases\GetTutorial;

interface GetTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  GetTutorialRequestModel  $request
     * @return GetTutorialResponseModel
     */
    public function handle(GetTutorialRequestModel $request): GetTutorialResponseModel;

}