<?php

namespace App\Usecases\ListTutorials;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

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
     * Handle an incoming request.
     *
     * @param  ListTutorialsRequestModel $request
     * @return ListTutorialsResponseModel
     */
    public function handle(ListTutorialsRequestModel $request)
    {
        $projectEntity = $this->projectRepository->selectOne([
            'user_id' => $request->userKey,
            'domain' => $request->domain,
        ]);

        $result = [
            'total' => null,
            'start' => null,
            'end' => null,
            'entities' => [],
            'domain' => null,
        ];

        if ($projectEntity) {
            $predicates = [
                [
                    'column' => 'project_id',
                    'operator' => '=',
                    'value' => $projectEntity->id,
                ],
                [
                    'column' => 'path',
                    'operator' => '=',
                    'value' => $request->path,
                ],
            ];

            $result = $this->tutorialRepository->paging(
                $predicates,
                $request->orders,
                $request->page,
                $request->search,
                $request->perPage
            );

            $result['domain'] = $projectEntity->domain;
        }

        return new ListTutorialsResponseModel($result);
    }
}