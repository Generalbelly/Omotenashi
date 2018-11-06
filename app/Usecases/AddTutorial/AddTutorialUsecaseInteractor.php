<?php

namespace App\Usecases\AddTutorial;

use App\Repositories\Site\SiteRepositoryContract;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use Log;

class AddTutorialUsecaseInteractor implements AddTutorialUsecase {

    /**
     * @var TutorialRepository
     */
    private $tutorialRepository;

    /**
     * @var SiteRepository
     */
    private $siteRepository;

    /**
     * AddTutorialUsecaseInteractor constructor.
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
     * @param AddTutorialRequestModel $request
     * @return AddTutorialResponseModel
     */
    public function handle(AddTutorialRequestModel $request)
    {
        $site = $this->siteRepository->selectOne([
            'domain' => $request->domain,
            'user_id' => $request->userKey,
        ]);
        if (!$site) {
            $site = $this->siteRepository->create([
                'name' => $request->domain,
                'domain' => $request->domain,
                'user_id' => $request->userKey,
            ]);
        }
        $tutorial = $this->tutorialRepository->create([
            'name' => $request->name,
            'description' => $request->description,
            'steps' => $request->steps,
            'url' => $request->url,
            'path' => $request->path,
            'query' => $request->query,
            'site_id' => $site->id,
        ]);
        return new AddTutorialResponseModel($tutorial->toArray());
    }

}