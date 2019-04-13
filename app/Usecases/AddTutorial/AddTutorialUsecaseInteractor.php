<?php

namespace App\Usecases\AddTutorial;

use App\Domains\Entities\ProjectEntity;
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
    public function handle(AddTutorialRequestModel $request): AddTutorialResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->find($request->project_id);
        $tutorial = $this->tutorialRepository->create([
            'name' => $request->name,
            'description' => $request->description,
            'steps' => $request->steps,
            'path' => $request->path,
            'parameters' => $request->parameters,
            'last_time_used_at' => [
                $request->path['value'] => null,
            ],
            'project_id' => $projectEntity->getAttribute('id'),
        ]);
        return new AddTutorialResponseModel($tutorial->toArray());
    }

}