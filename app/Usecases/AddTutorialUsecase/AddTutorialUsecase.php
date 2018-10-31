<?php

namespace App\Usecases\AddTutorialUsecase;

interface AddTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  AddTutorialRequestModel  $request
     * @return AddTutorialResponseModel
     */
    public function handle(AddTutorialRequestModel $request);

}