<?php

namespace App\Usecases\DeleteTutorial;

interface DeleteTutorialUsecase {

    /**
     * @param DeleteTutorialRequestModel $request
     * @return DeleteTutorialResponseModel
     */
    public function handle(DeleteTutorialRequestModel $request): DeleteTutorialResponseModel;

}