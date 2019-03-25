<?php

namespace App\Usecases\UpdateTutorial;

use App\Domains\Entities\TutorialEntity;
use App\Repositories\Tutorial\TutorialRepositoryContract;

class UpdateTutorialUsecaseInteractor implements UpdateTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * UpdateTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository
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