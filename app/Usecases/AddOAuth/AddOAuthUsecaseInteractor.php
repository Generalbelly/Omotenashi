<?php

namespace App\Usecases\AddOAuth;

use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
use Log;

class AddOAuthUsecaseInteractor implements AddOAuthUsecase {

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
     * @param AddOAuthRequestModel $request
     * @return AddOAuthResponseModel
     */
    public function handle(AddOAuthRequestModel $request): AddOAuthResponseModel
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

        return new AddOAuthResponseModel($projectEntity->toArray());
    }

}