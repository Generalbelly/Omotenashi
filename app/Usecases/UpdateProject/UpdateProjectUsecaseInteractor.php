<?php

namespace App\Usecases\UpdateProject;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\GoogleAnalyticsProperty\GoogleAnalyticsPropertyRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class UpdateProjectUsecaseInteractor implements UpdateProjectUsecase {

    private $projectRepository;
    private $googleAnalyticsPropertyRepository;

    public function __construct(
        ProjectRepositoryContract $projectRepository,
        GoogleAnalyticsPropertyRepositoryContract $googleAnalyticsPropertyRepository
    ){
        $this->projectRepository = $projectRepository;
        $this->googleAnalyticsPropertyRepository = $googleAnalyticsPropertyRepository;
    }

    /**
     * @param UpdateProjectRequestModel $request
     * @return UpdateProjectResponseModel
     */
    public function handle(UpdateProjectRequestModel $request): UpdateProjectResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->update([
            'domain' => $request->domain,
            'protocol' => $request->protocol,
            'name' => $request->name,
            'tutorial_settings' => $request->tutorial_settings,
        ], $request->id);

        $googleAnalyticsPropertyEntities = $this->googleAnalyticsPropertyRepository->batchUpdate(
            $request->googleAnalyticsPropertyEntities,
            $projectEntity,
            'googleAnalyticsPropertyEntities',
            'project_id'
        );

        $projectEntity->getAttribute('oauthEntities');

        return new UpdateProjectResponseModel(array_merge($projectEntity->toArray(),[
            'google_analytics_property_entities' => $googleAnalyticsPropertyEntities,
        ]));
    }

}