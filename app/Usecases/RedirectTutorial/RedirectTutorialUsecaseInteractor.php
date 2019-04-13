<?php

namespace App\Usecases\RedirectTutorial;

use App\Domains\Models\OAuth\OAuthService;
use App\Repositories\Project\ProjectRepositoryContract;
use Exception;
use App;

class RedirectTutorialUsecaseInteractor implements RedirectTutorialUsecase {

    private $projectRepository;

    /**
     * GetProjectUsecaseInteractor constructor.
     * @param ProjectRepositoryContract $projectRepository
     */
    public function __construct(
        ProjectRepositoryContract $projectRepository
    ){
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param RedirectTutorialRequestModel $request
     * @return RedirectTutorialResponseModel
     * @throws Exception
     */
    public function handle(RedirectTutorialRequestModel $request): RedirectTutorialResponseModel
    {
        /** @var App\Domains\Entities\ProjectEntity $projectEntity */
        $projectEntity = $this->projectRepository->find($request->projectId);

        $path = '/';
        if ($request->id) {
            // TODO Tutorial編集のとき
        }

        return new RedirectTutorialResponseModel([
            'url'   => sprintf('%s://%s%s',
                $projectEntity->getAttribute('protocol'),
                $projectEntity->getAttribute('domain'),
                $path
            )
        ]);
    }

}