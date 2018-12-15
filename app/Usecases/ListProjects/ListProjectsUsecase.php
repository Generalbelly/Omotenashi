<?php

namespace App\Usecases\ListProjects;

interface ListProjectsUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  ListProjectsRequestModel  $request
     * @return ListProjectsResponseModel
     */
    public function handle(ListProjectsRequestModel $request): ListProjectsResponseModel;

}