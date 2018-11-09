<?php

namespace App\Usecases\DeleteTutorial;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Site\SiteRepositoryContract;

class DeleteTutorialUsecaseInteractor implements DeleteTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var SiteRepositoryContract
     */
    private $siteRepository;

    /**
     * DeleteTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param SiteRepositoryContract $siteRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
        SiteRepositoryContract $siteRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->siteRepository = $siteRepository;
    }

    /**
     * @param DeleteTutorialRequestModel $request
     * @return DeleteTutorialResponseModel
     */
    public function handle(DeleteTutorialRequestModel $request)
    {
        $tutorial = $this->tutorialRepository->delete($request->id);
        return new DeleteTutorialResponseModel($tutorial->toArray());
    }
}