<?php

namespace App\Usecases\DeleteTutorial;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;

class DeleteTutorialUsecaseInteractor implements DeleteTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * DeleteTutorialUsecaseInteractor constructor.
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
     * @param DeleteTutorialRequestModel $request
     * @return DeleteTutorialResponseModel
     */
    public function handle(DeleteTutorialRequestModel $request): DeleteTutorialResponseModel
    {
        $tutorial = $this->tutorialRepository->delete($request->id);
        return new DeleteTutorialResponseModel($tutorial->toArray());
    }
}