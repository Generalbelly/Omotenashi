<?php

namespace App\Usecases\AddTutorial;

interface AddTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  AddTutorialRequestModel  $request
     * @return AddTutorialResponseModel
     */
    public function handle(AddTutorialRequestModel $request);

}