<?php

namespace App\Usecases\GetProject;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class GetProjectUsecaseInteractor implements GetProjectUsecase {

    private $projectRepository;

    /**
     * GetProjectUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository
    ){
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param GetProjectRequestModel $request
     * @return GetProjectResponseModel
     */
    public function handle(GetProjectRequestModel $request): GetProjectResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->find($request->id);
        $projectEntity->getAttribute('whitelistedDomainEntities');
        $projectEntity->getAttribute('oauthEntities');
        $projectEntity->getAttribute('googleAnalyticsPropertyEntities');
        return new GetProjectResponseModel($projectEntity->toArray());
    }

}