<?php

namespace App\Usecases\UpdateProject;

interface UpdateProjectUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  UpdateProjectRequestModel  $request
     * @return UpdateProjectResponseModel
     */
    public function handle(UpdateProjectRequestModel $request): UpdateProjectResponseModel;

}