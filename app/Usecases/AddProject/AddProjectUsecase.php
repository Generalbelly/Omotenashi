<?php

namespace App\Usecases\AddProject;

interface AddProjectUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  AddProjectRequestModel  $request
     * @return AddProjectResponseModel
     */
    public function handle(AddProjectRequestModel $request): AddProjectResponseModel;

}