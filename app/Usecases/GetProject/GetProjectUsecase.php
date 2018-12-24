<?php

namespace App\Usecases\GetProject;

interface GetProjectUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  GetProjectRequestModel  $request
     * @return GetProjectResponseModel
     */
    public function handle(GetProjectRequestModel $request): GetProjectResponseModel;

}