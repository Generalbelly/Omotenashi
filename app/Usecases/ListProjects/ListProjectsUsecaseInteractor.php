<?php

namespace App\Usecases\ListProjects;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use Log;

class ListProjectsUsecaseInteractor implements ListProjectsUsecase {

    /**
     * @var ProjectRepositoryContract
     */
    private $projectRepository;

    /**
     * ListProjectsUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository
    ){
        $this->projectRepository = $projectRepository;
    }


    /**
     * Handle an incoming request.
     *
     * @param  ListProjectsRequestModel $request
     * @return ListProjectsResponseModel
     */
    public function handle(ListProjectsRequestModel $request): ListProjectsResponseModel
    {
        $predicates = [
            [
                'column' => 'user_id',
                'operator' => '=',
                'value' => $request->userKey,
            ],
        ];

        $result = $this->projectRepository->paging(
            $predicates,
            $request->orders,
            $request->page,
            $request->search,
            $request->perPage
        );

        return new ListProjectsResponseModel($result);
    }
}