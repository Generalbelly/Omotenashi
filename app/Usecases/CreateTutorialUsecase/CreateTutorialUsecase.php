<?php

namespace App\Usecases\CreateTutorialUsecase;

interface CreateTutorialUsecase {

    /**
     * Handle an incoming request.
     *
     * @param  CreateTutorialRequest  $request
     * @return CreateTutorialResponse
     */
    public function handle(CreateTutorialRequest $request);

}