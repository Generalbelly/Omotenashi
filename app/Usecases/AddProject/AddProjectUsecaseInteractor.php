<?php

namespace App\Usecases\AddProject;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Log;

class AddProjectUsecaseInteractor implements AddProjectUsecase {

    private $projectRepository;
    private $whitelistedDomainRepository;

    /**
     * AddProjectUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     * @param WhitelistedDomainRepositoryContract $whitelistedDomainRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository,
        WhitelistedDomainRepositoryContract $whitelistedDomainRepository
    ){
        $this->projectRepository = $projectRepository;
        $this->whitelistedDomainRepository = $whitelistedDomainRepository;
    }

    /**
     * @param AddProjectRequestModel $request
     * @return AddProjectResponseModel
     */
    public function handle(AddProjectRequestModel $request): AddProjectResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->create([
            'name' => $request->name,
            'domain' => $request->domain,
            'protocol' => $request->protocol,
            'user_id' => $request->userKey,
        ]);

        foreach ($request->whitelistedDomainEntities as $whitelistedDomain) {
            $this->whitelistedDomainRepository->create([
                'domain' => $whitelistedDomain['domain'],
                'protocol' => $whitelistedDomain['protocol'],
                'project_id' => $projectEntity->getAttribute('id'),
            ]);
        }

        $projectEntity->getAttribute('whitelistedDomainEntities');

        return new AddProjectResponseModel($projectEntity->toArray());
    }

}