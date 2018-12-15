<?php

namespace App\Usecases\UpdateTutorial;

interface UpdateTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  UpdateTutorialRequestModel  $request
     * @return UpdateTutorialResponseModel
     */
    public function handle(UpdateTutorialRequestModel $request): UpdateTutorialResponseModel;

}