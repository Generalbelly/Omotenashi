<?php

namespace App\Usecases\AddProject;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Log;

class AddProjectUsecaseInteractor implements AddProjectUsecase {

    /**
     * @var ProjectRepository
     */
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
                'project_id' => $projectEntity->id,
            ]);
        }

        return new AddProjectResponseModel($projectEntity->toArray());
    }

}