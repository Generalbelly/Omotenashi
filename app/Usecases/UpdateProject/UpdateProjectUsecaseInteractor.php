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
        ], $request->id);

        $this->whitelistedDomainRepository->batchUpdate(
            $request->whitelistedDomainEntities,
            $projectEntity,
            'whitelistedDomainEntities',
            'project_id'
        );

        $this->googleAnalyticsPropertyRepository->batchUpdate(
            $request->googleAnalyticsPropertyEntities,
            $projectEntity,
            'googleAnalyticsPropertyEntities',
            'project_id'
        );

//        $oldEntities = $projectEntity->getAttribute('whitelistedDomainEntities')->toArray();
//        $newEntities = [];
//
//        foreach ($request->whitelistedDomainEntities as $whitelistedDomain) {
//            $whitelistedDomainEntity = null;
//            if ($whitelistedDomain['id']) {
//                $whitelistedDomainEntity = $this->whitelistedDomainRepository->update([
//                    'domain' => $whitelistedDomain['domain'],
//                    'protocol' => $whitelistedDomain['protocol'],
//                ], $whitelistedDomain['id']);
//            } else {
//                $whitelistedDomainEntity = $this->whitelistedDomainRepository->create([
//                    'domain' => $whitelistedDomain['domain'],
//                    'protocol' => $whitelistedDomain['protocol'],
//                    'project_id' => $projectEntity->getAttribute('id'),
//                ]);
//            }
//            $newEntities[] = $whitelistedDomainEntity;
//        }
//
//
//        $entityIdsToDelete = array_diff(
//            array_column($oldEntities, 'id'),
//            array_column($newEntities, 'id')
//        );
//
//        $this->whitelistedDomainRepository->destroy($entityIdsToDelete);

        $projectEntity->whitelistedDomainEntities()->get();
        $projectEntity->oauthEntities()->get();
        $projectEntity->googleAnalyticsPropertyEntities()->get();

        return new UpdateProjectResponseModel($projectEntity->toArray());
    }

}