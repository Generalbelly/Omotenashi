<?php

namespace App\Usecases\DeleteTutorial;

use App\Repositories\Tutorial\TutorialRepositoryContract;

class DeleteTutorialUsecaseInteractor implements DeleteTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * DeleteTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository
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