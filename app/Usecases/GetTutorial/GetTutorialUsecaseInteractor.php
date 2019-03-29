<?php

namespace App\Usecases\GetTutorial;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\Exceptions\TutorialNotFound;
use App\Domains\Entities\GoogleAnalyticsPropertyEntity;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Repositories\GoogleAnalyticsProperty\GoogleAnalyticsPropertyRepository;
use App\Repositories\Tutorial\TutorialStepRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Carbon\Carbon;

class GetTutorialUsecaseInteractor implements GetTutorialUsecase {

    /**
     * @var TutorialStepRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * @var GoogleAnalyticsPropertyRepository
     */
    private $googleAnalyticsPropertyRepository;

    /**
     * GetTutorialUsecaseInteractor constructor.
     * @param TutorialStepRepositoryContract $tutorialRepository
     * @param ProjectRepositoryContract $projectRepository
     * @param GoogleAnalyticsPropertyRepository $googleAnalyticsPropertyRepository
     */
    public function __construct(
        TutorialStepRepositoryContract $tutorialRepository,
        ProjectRepositoryContract $projectRepository,
        GoogleAnalyticsPropertyRepository $googleAnalyticsPropertyRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->projectRepository = $projectRepository;
        $this->googleAnalyticsPropertyRepository = $googleAnalyticsPropertyRepository;
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

        if (!$projectEntity) {
            throw new ProjectNotFound($request->domain);
        }
        $entities = $this->tutorialRepository->where([
            'path->deepness' => $request->deepness,
            'project_id' => $projectEntity->getAttribute('id'),
        ])->get();

        if (count($entities) === 0) {
            throw new TutorialNotFound('Tutorial not found', 404);
        }

        $tutorialEntities = [];
        /** @var TutorialEntity $tutorialEntity */
        foreach ($entities as $tutorialEntity) {
            if ($tutorialEntity->getAttribute('query') != $request->query) continue;
            $path = $tutorialEntity->getAttribute('path');
            if ((
                    $path['regex'] == false &&
                    $path['value'] === $request->path
                ) || (
                    $path['regex'] == true &&
                    preg_match(TutorialEntity::generateRegex($path['value']), $request->path)
                )) {
                $tutorialEntities[] = $tutorialEntity;
            }
        }

        if (count($tutorialEntities) === 0) {
            throw new TutorialNotFound('Tutorial not found', 404);
        }

        $tutorialSettings = $projectEntity->getAttribute('tutorialSettings');
        if ($tutorialSettings['distribution_ratio'] === 'random') {
            $tutorialIndex = rand(0, count($tutorialEntities) - 1);
            $tutorialEntity = $tutorialEntities[$tutorialIndex];
        } else {
            $tutorialIndex = 0;
            $oldestTimestamp = null;
            /** @var TutorialEntity $tutorialEntity */
            foreach ($tutorialEntities as $index => $tutorialEntity) {
                $lastTimeUsedAt = $tutorialEntity->getAttribute('last_time_used_at');
                // 正規表現のときここにくる
                if (!array_key_exists($request->path, $lastTimeUsedAt)) {
                    $tutorialIndex = $index;
                    break;
                }
                if (is_null($lastTimeUsedAt[$request->path])) {
                    $tutorialIndex = $index;
                    break;
                }
                $timestamp = (new Carbon($lastTimeUsedAt[$request->path]))->getTimestamp();
                if (is_null($oldestTimestamp) || $timestamp < $oldestTimestamp ) {
                    $oldestTimestamp = $timestamp;
                    $tutorialIndex = $index;
                }
            }
            $tutorialEntity = $tutorialEntities[$tutorialIndex];
            $this->tutorialRepository->update([
                'last_time_used_at' => array_merge(
                    $tutorialEntity->getAttribute('last_time_used_at'),
                    [
                        $request->path => now()->getTimestamp(),
                    ]
                ),
            ], $tutorialEntity->getAttribute('id'));
        }

        /** @var GoogleAnalyticsPropertyEntity $googleAnalyticsPropertyEntity */
        $googleAnalyticsPropertyEntity = $this->googleAnalyticsPropertyRepository->where([
            'project_id' => $projectEntity->getAttribute('id'),
        ])->first();

        $response = array_merge(
            [
                'tutorial' => $tutorialEntity->toArray(),
                'property_id' => $googleAnalyticsPropertyEntity ? $googleAnalyticsPropertyEntity->getAttribute('property_id') : null,
                'tutorial_settings' => $tutorialSettings,
            ]
        );
        return new GetTutorialResponseModel($response);

    }
}