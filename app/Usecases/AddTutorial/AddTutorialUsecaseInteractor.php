<?php

namespace App\Usecases\AddTutorial;

use App\Repositories\Project\ProjectRepositoryContract;
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
    private $projectRepository;

    /**
     * AddTutorialUsecaseInteractor constructor.
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
     * @param AddTutorialRequestModel $request
     * @return AddTutorialResponseModel
     */
    public function handle(AddTutorialRequestModel $request)
    {
        $projectEntity = $this->projectRepository->selectOne([
            'domain' => $request->domain,
            'user_id' => $request->userKey,
        ]);
        if (!$projectEntity) {
            $projectEntity = $this->projectRepository->create([
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
            'project_id' => $projectEntity->id,
        ]);
        return new AddTutorialResponseModel($tutorial->toArray());
    }

}