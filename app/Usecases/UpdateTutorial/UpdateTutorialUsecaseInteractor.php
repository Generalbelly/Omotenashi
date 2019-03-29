<?php

namespace App\Usecases\UpdateTutorial;

use App\Domains\Entities\TutorialEntity;
use App\Repositories\Tutorial\TutorialStepRepositoryContract;

class UpdateTutorialUsecaseInteractor implements UpdateTutorialUsecase {

    /**
     * @var TutorialStepRepositoryContract
     */
    private $tutorialRepository;

    /**
     * UpdateTutorialUsecaseInteractor constructor.
     * @param TutorialStepRepositoryContract $tutorialRepository
     */
    public function __construct(
        TutorialStepRepositoryContract $tutorialRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
    }


    /**
     * @param UpdateTutorialRequestModel $request
     * @return UpdateTutorialResponseModel
     */
    public function handle(UpdateTutorialRequestModel $request): UpdateTutorialResponseModel
    {
        /** @var TutorialEntity $tutorialEntity */
        $tutorialEntity = $this->tutorialRepository->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'steps' => $request->steps,
                'path' => $request->path,
                'parameters' => $request->parameters,
            ],
            $request->id
        );
        return new UpdateTutorialResponseModel($tutorialEntity->toArray());
    }
}