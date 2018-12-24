<?php

namespace App\Usecases\UpdateTutorial;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class UpdateTutorialUsecaseInteractor implements UpdateTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * UpdateTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
        ProjectRepositoryContract $projectRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->projectRepository = $projectRepository;
    }


    /**
     * @param UpdateTutorialRequestModel $request
     * @return UpdateTutorialResponseModel
     */
    public function handle(UpdateTutorialRequestModel $request): UpdateTutorialResponseModel
    {
        $tutorial = $this->tutorialRepository->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'steps' => $request->steps,
            ],
            $request->id,
        );

        return new UpdateTutorialResponseModel($tutorial->toArray());
    }
}