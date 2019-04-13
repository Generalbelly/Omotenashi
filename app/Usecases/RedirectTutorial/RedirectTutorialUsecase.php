<?php

namespace App\Usecases\RedirectTutorial;

interface RedirectTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  RedirectTutorialRequestModel  $request
     * @return RedirectTutorialResponseModel
     */
    public function handle(RedirectTutorialRequestModel $request): RedirectTutorialResponseModel;

}