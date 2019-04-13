<?php

namespace App\Usecases\ListTutorials;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\ProjectEntity;
use App\Domains\Entities\TutorialEntity;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;
use DB;

class ListTutorialsUsecaseInteractor implements ListTutorialsUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * ListTutorialsUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
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
        $projectID = $request->project_id;
        $projectEntity = null;

        if ($request->domain) {
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
            $projectID = $projectEntity->getAttribute('id');
        }

        $result = $this->tutorialRepository->paging(
            [
                [
                    'column' => 'project_id',
                    'operator' => '=',
                    'value' => $projectID,
                ],
            ],
            $request->orders,
            $request->page,
            $request->search,
            $request->perPage
        );

        return new ListTutorialsResponseModel(array_merge(
            $result,
            [
                'projectEntity' => $projectEntity ? $projectEntity->toArray() : null,
            ]
        ));
    }
}