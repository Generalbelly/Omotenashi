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
                'query' => $request->query,
            ],
            $request->id
        );
        $projectEntity = $tutorialEntity->getAttribute('projectEntity');

        return new UpdateTutorialResponseModel(array_merge(
            $tutorialEntity->toArray(),
            [
                'domain' => $projectEntity->getAttribute('domain'),
                'protocol' => $projectEntity->getAttribute('protocol'),
            ]
        ));
    }
}