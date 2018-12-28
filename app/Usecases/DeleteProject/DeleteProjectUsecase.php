<?php

namespace App\Usecases\DeleteProject;

interface DeleteProjectUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  DeleteProjectRequestModel  $request
     * @return DeleteProjectResponseModel
     */
    public function handle(DeleteProjectRequestModel $request): DeleteProjectResponseModel;

}