<?php

namespace App\Usecases\GetTutorial;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\Exceptions\TutorialNotFound;
use App\Domains\Entities\ProjectEntity;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class GetTutorialUsecaseInteractor implements GetTutorialUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * GetTutorialUsecaseInteractor constructor.
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
     * @param GetTutorialRequestModel $request
     * @return GetTutorialResponseModel
     * @throws ProjectNotFound
     * @throws TutorialNotFound
     */
    public function handle(GetTutorialRequestModel $request): GetTutorialResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->where([
            'user_id' => $request->userKey,
            'domain' => $request->domain,
        ])->first();

        if ($projectEntity) {
            $tutorialEntity = $this->tutorialRepository->where([
                'path' => $request->path,
                'query' => $request->query,
                'project_id' => $projectEntity->getAttribute('id'),
            ])->first();
            if (!$tutorialEntity) {
                throw new TutorialNotFound('Tutorial not found', 404);
            }
        } else {
            throw new ProjectNotFound($request->domain);
        }

        return new GetTutorialResponseModel($tutorialEntity->toArray());
    }
}