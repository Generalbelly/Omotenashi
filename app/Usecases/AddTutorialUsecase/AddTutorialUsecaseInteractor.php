<?php

namespace App\Usecases\AddTutorialUsecase;

use App\Repositories\Site\SiteRepositoryContract;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryContract;

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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AddTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param SiteRepositoryContract $siteRepository
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
        SiteRepositoryContract $siteRepository,
        UserRepositoryContract $userRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->siteRepository = $siteRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param AddTutorialRequestModel $request
     * @return AddTutorialResponseModel
     */
    public function handle(AddTutorialRequestModel $request)
    {
        $site = $this->siteRepository->findByDomain($request->domain);

        $user = $this->userRepository->findBySub($request->sub);

        if (!$site) {
            $site = $this->siteRepository->add([
                'domain' => $request->domain,
                'name' => $request->domain,
                'user' => $user->sub
            ]);
        }
        $tutorial = $this->tutorialRepository->add([
            'name' => $request->name,
            'description' => $request->description,
            'steps' => $request->steps,
            'path' => $request->path,
            'site_id' => $site->id,
        ]);
        return new AddTutorialResponseModel($tutorial->toArray());
    }

}