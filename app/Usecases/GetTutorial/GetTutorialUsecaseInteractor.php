<?php

namespace App\Usecases\GetTutorial;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\Exceptions\TutorialNotFound;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Carbon\Carbon;

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
            $tutorialEntities = $this->tutorialRepository->where([
                'path' => $request->path,
                'query' => $request->query,
                'project_id' => $projectEntity->getAttribute('id'),
            ])->get();

            if (count($tutorialEntities) === 0) {
                throw new TutorialNotFound('Tutorial not found', 404);
            }

            $tutorialSettings = $projectEntity->getAttribute('tutorialSettings');
            if ($tutorialSettings['distribution_ratio'] === 'random') {
                $tutorialIndex = rand(0, count($tutorialEntities) - 1);
                $tutorialEntity = $tutorialEntities[$tutorialIndex];
            } else {
                $tutorialIndex = null;
                $oldestTimestamp = null;
                /** @var TutorialEntity $tutorialEntity */
                foreach ($tutorialEntities as $index => $tutorialEntity) {
                    $timestamp = $tutorialEntity->getAttribute('last_time_used_at')->getTimestamp();
                    if (is_null($oldestTimestamp) || $timestamp < $oldestTimestamp ) {
                        $oldestTimestamp = $timestamp;
                        $tutorialIndex = $index;
                    }
                }
                $tutorialEntity = $tutorialEntities[$tutorialIndex];
                $this->tutorialRepository->update([
                    'last_time_used_at' => now(),
                ], $tutorialEntity->getAttribute('id'));
            }

        } else {
            throw new ProjectNotFound($request->domain);
        }

        return new GetTutorialResponseModel($tutorialEntity->toArray());
    }
}