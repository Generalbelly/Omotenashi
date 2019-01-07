<?php

namespace App\Usecases\UpdateProject;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Log;

class UpdateProjectUsecaseInteractor implements UpdateProjectUsecase {

    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    private $whitelistedDomainRepository;

    /**
     * UpdateProjectUsecaseInteractor constructor.
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
     * @param UpdateProjectRequestModel $request
     * @return UpdateProjectResponseModel
     */
    public function handle(UpdateProjectRequestModel $request): UpdateProjectResponseModel
    {
        $projectEntity = $this->projectRepository->update([
            'domain' => $request->domain,
            'protocol' => $request->protocol,
            'name' => $request->name,
        ], $request->id);

        $oldEntities = $projectEntity->whitelistedDomainEntities->toArray();
        $newEntities = [];

        foreach ($request->whitelistedDomainEntities as $whitelistedDomain) {
            $whitelistedDomainEntity = null;
            if ($whitelistedDomain['id']) {
                $whitelistedDomainEntity = $this->whitelistedDomainRepository->update([
                    'domain' => $whitelistedDomain['domain'],
                    'protocol' => $whitelistedDomain['protocol'],
                ], $whitelistedDomain['id']);
            } else {
                $whitelistedDomainEntity = $this->whitelistedDomainRepository->create([
                    'domain' => $whitelistedDomain['domain'],
                    'protocol' => $whitelistedDomain['protocol'],
                    'project_id' => $projectEntity->id,
                ]);
            }
            $newEntities[] = $whitelistedDomainEntity;
        }

        $entityIdsToDelete = array_diff(
            array_column($oldEntities, 'id'),
            array_column($newEntities, 'id')
        );

        $this->whitelistedDomainRepository->destroy($entityIdsToDelete);

        return new UpdateProjectResponseModel($projectEntity->toArray());
    }

}