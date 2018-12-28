<?php

namespace App\Usecases\ListTutorials;

use App\Exceptions\ProjectNotFound;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;

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
        $projectEntity = $this->projectRepository->selectOne([
            'user_id' => $request->userKey,
            'domain' => $request->domain,
        ]);

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
        } else {
            throw new ProjectNotFound($request->domain);
        }

        return new ListTutorialsResponseModel($result);
    }
}