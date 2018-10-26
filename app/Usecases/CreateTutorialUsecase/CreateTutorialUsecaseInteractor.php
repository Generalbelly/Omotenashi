<?php

namespace App\Usecases\CreateTutorialUsecase;

use App\Repositories\Tutorial\TutorialRepository;
use Log;

class CreateTutorialUsecaseInteractor implements CreateTutorialUsecase {

    /**
     * @var TutorialRepository
     */
    private $tutorialRepository;

    public function __construct(TutorialRepository $tutorialRepository)
    {
        $this->tutorialRepository = $tutorialRepository;
    }

    /**
     * @param CreateTutorialRequest $request
     * @return CreateTutorialResponse
     */
    public function handle(CreateTutorialRequest $request)
    {
        Log::error($request->name);
        $tutorial = $this->tutorialRepository->create([
            'name' => $request->name,
            'description' => $request->description,
            'steps' => $request->steps,
            'path' => $request->path,
            'site_id' => '00000fjosjlfo',
        ]);
        return new CreateTutorialResponse($tutorial->toArray());
    }

}