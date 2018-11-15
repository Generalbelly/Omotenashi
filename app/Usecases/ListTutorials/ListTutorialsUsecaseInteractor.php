<?php

namespace App\Usecases\ListTutorials;

use App\Repositories\Tutorial\TutorialRepositoryContract;
use App\Repositories\Site\SiteRepositoryContract;
use Log;

class ListTutorialsUsecaseInteractor implements ListTutorialsUsecase {

    /**
     * @var TutorialRepositoryContract
     */
    private $tutorialRepository;

    /**
     * @var SiteRepositoryContract
     */
    private $siteRepository;

    /**
     * ListTutorialsUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     * @param SiteRepositoryContract $siteRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository,
        SiteRepositoryContract $siteRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
        $this->siteRepository = $siteRepository;
    }


    /**
     * Handle an incoming request.
     *
     * @param  ListTutorialsRequestModel $request
     * @return ListTutorialsResponseModel
     */
    public function handle(ListTutorialsRequestModel $request)
    {
        Log::error($request->domain);
        $site = $this->siteRepository->selectOne([
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

        if ($site) {
            $predicates = [
                [
                    'column' => 'site_id',
                    'operator' => '=',
                    'value' => $site->id,
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

            $result['domain'] = $site->domain;
        }

        return new ListTutorialsResponseModel($result);
    }
}