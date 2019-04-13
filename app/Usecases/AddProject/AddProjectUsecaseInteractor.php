<?php

namespace App\Usecases\AddProject;

use App\Domains\Entities\ProjectEntity;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class AddProjectUsecaseInteractor implements AddProjectUsecase {

    private $projectRepository;

    /**
     * AddProjectUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository
    ){
        $this->projectRepository = $projectRepository;
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
            'tutorial_settings' => $request->tutorial_settings,
            'user_id' => $request->userKey,
        ]);

        return new AddProjectResponseModel($projectEntity->toArray());
    }

}