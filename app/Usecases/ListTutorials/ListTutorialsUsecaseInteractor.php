<?php

namespace App\Usecases\ListTutorials;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Repositories\Tutorial\TutorialStepRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;
use DB;

class ListTutorialsUsecaseInteractor implements ListTutorialsUsecase {

    /**
     * @var TutorialStepRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * ListTutorialsUsecaseInteractor constructor.
     * @param TutorialStepRepositoryContract $tutorialRepository
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        TutorialStepRepositoryContract $tutorialRepository,
        ProjectRepositoryContract $projectRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->projectRepository = $projectRepository;
    }


    /**
     * @param ListTutorialsRequestModel $request
     * @return ListTutorialsResponseModel
     * @throws ProjectNotFound
     */
    public function handle(ListTutorialsRequestModel $request): ListTutorialsResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->where([
            [
                'column' => 'user_id',
                'operator' => '=',
                'value' => $request->userKey,
            ],
            [
                'column' => 'domain',
                'operator' => '=',
                'value' => $request->domain,
            ]
        ])->first();

        if (!$projectEntity) {
            throw new ProjectNotFound($request->domain);
        }

        $predicates = [
            [
                'column' => 'project_id',
                'operator' => '=',
                'value' => $projectEntity->getAttribute('id'),
            ],
        ];

        $result = $this->tutorialRepository->paging(
            $predicates,
            $request->orders,
            $request->page,
            $request->search,
            $request->perPage
        );

        return new ListTutorialsResponseModel(array_merge(
            $result,
            [
                'projectEntity' => $projectEntity->toArray(),
            ]
        ));
    }
}