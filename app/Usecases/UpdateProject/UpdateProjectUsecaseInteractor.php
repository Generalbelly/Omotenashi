<?php

namespace App\Usecases\UpdateProject;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\GoogleAnalyticsProperty\GoogleAnalyticsPropertyRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Log;

class UpdateProjectUsecaseInteractor implements UpdateProjectUsecase {

    private $projectRepository;
    private $whitelistedDomainRepository;
    private $googleAnalyticsPropertyRepository;

    public function __construct(
        ProjectRepositoryContract $projectRepository,
        WhitelistedDomainRepositoryContract $whitelistedDomainRepository,
        GoogleAnalyticsPropertyRepositoryContract $googleAnalyticsPropertyRepository
    ){
        $this->projectRepository = $projectRepository;
        $this->whitelistedDomainRepository = $whitelistedDomainRepository;
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
            'settings' => $request->settings,
        ], $request->id);

        $whitelistedDomainEntities = $this->whitelistedDomainRepository->batchUpdate(
            $request->whitelistedDomainEntities,
            $projectEntity,
            'whitelistedDomainEntities',
            'project_id'
        );

        $googleAnalyticsPropertyEntities = $this->googleAnalyticsPropertyRepository->batchUpdate(
            $request->googleAnalyticsPropertyEntities,
            $projectEntity,
            'googleAnalyticsPropertyEntities',
            'project_id'
        );

        $projectEntity->getAttribute('oauthEntities');

        return new UpdateProjectResponseModel(array_merge($projectEntity->toArray(),[
            'google_analytics_property_entities' => $googleAnalyticsPropertyEntities,
            'whitelisted_domain_entities' => $whitelistedDomainEntities,
        ]));
    }

}