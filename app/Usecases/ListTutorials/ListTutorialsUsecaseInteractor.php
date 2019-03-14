<?php

namespace App\Usecases\ListTutorials;

use App\Domains\Entities\Exceptions\ProjectNotFound;
use App\Domains\Entities\ProjectEntity;
use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Project\ProjectRepositoryContract;
use App\Repositories\WhitelistedDomain\WhitelistedDomainRepositoryContract;
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
     * @var WhitelistedDomainRepositoryContract
     */
    private $whitelistedDomainRepository;

    /**
     * ListTutorialsUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param ProjectRepositoryContract $projectRepository
     * @param WhitelistedDomainRepositoryContract $whitelistedDomainRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
        ProjectRepositoryContract $projectRepository,
        WhitelistedDomainRepositoryContract $whitelistedDomainRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->projectRepository = $projectRepository;
        $this->whitelistedDomainRepository = $whitelistedDomainRepository;
    }


    /**
     * @param ListTutorialsRequestModel $request
     * @return ListTutorialsResponseModel
     * @throws ProjectNotFound
     */
    public function handle(ListTutorialsRequestModel $request): ListTutorialsResponseModel
    {
        /** @var ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->where('user_id', $request->userKey)->whereHas(
            'whitelistedDomainEntities', function($query) use ($request) {
                $query->where('domain', '=', $request->domain);
        })->first();

        if ($projectEntity) {
            $predicates = [
                [
                    'column' => 'project_id',
                    'operator' => '=',
                    'value' => $projectEntity->getAttribute('id'),
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
            $result['projectEntity'] = $projectEntity->toArray();
        } else {
            throw new ProjectNotFound($request->domain);
        }

        return new ListTutorialsResponseModel($result);
    }
}