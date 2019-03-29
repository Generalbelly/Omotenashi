<?php

namespace App\Usecases\DeleteTutorial;

use App\Repositories\Tutorial\TutorialStepRepositoryContract;

class DeleteTutorialUsecaseInteractor implements DeleteTutorialUsecase {

    /**
     * @var TutorialStepRepositoryContract
     */
    private $tutorialRepository;

    /**
     * DeleteTutorialUsecaseInteractor constructor.
     * @param TutorialStepRepositoryContract $tutorialRepository
     */
    public function __construct(
        TutorialStepRepositoryContract $tutorialRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
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