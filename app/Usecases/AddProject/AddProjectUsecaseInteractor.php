<?php

namespace App\Usecases\AddProject;

use App\Repositories\Project\ProjectRepositoryContract;

class AddProjectUsecaseInteractor implements AddProjectUsecase {

    /**
     * @var ProjectRepository
     */
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
        $projectEntity = $this->projectRepository->selectOne([
            'domain' => $request->domain,
            'user_id' => $request->userKey,
        ]);
        if (!$projectEntity) {
            $projectEntity = $this->projectRepository->create([
                'name' => $request->name,
                'domain' => $request->domain,
                'user_id' => $request->userKey,
            ]);
        }
        return new AddProjectResponseModel($projectEntity->toArray());
    }

}