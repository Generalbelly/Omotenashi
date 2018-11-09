<?php

namespace App\Usecases\UpdateTutorial;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Site\SiteRepositoryContract;
use Log;

class UpdateTutorialUsecaseInteractor implements UpdateTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var SiteRepositoryContract
     */
    private $siteRepository;

    /**
     * UpdateTutorialUsecaseInteractor constructor.
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
     * @param UpdateTutorialRequestModel $request
     * @return UpdateTutorialResponseModel
     */
    public function handle(UpdateTutorialRequestModel $request)
    {
        $tutorial = $this->tutorialRepository->update(
            $request->id,
            [
                'name' => $request->name,
                'description' => $request->description,
                'steps' => $request->steps,
            ]
        );

        return new UpdateTutorialResponseModel($tutorial->toArray());
    }
}