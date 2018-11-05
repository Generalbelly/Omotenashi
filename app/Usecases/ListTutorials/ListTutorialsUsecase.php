<?php

namespace App\Usecases\ListTutorials;

interface ListTutorialsUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  ListTutorialsRequestModel  $request
     * @return ListTutorialsResponseModel
     */
    public function handle(ListTutorialsRequestModel $request);

}