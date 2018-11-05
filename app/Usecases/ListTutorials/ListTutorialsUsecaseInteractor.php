<?php

namespace App\Usecases\ListTutorials;

use App\Repositories\Tutorial\TutorialRepositoryContract;

class ListTutorialsUsecaseInteractor implements ListTutorialsUsecase {

    /**
     * @var TutorialRepository
     */
    private $tutorialRepository;

    /**
     * ListTutorialUsecaseInteractor constructor.
     * @param TutorialRepositoryContract $tutorialRepository
     */
    public function __construct(
        TutorialRepositoryContract $tutorialRepository
    ){
        $this->tutorialRepository = $tutorialRepository;
    }


    /**
     * Handle an incoming request.
     *
     * @param  ListTutorialsRequestModel $request
     * @return ListTutorialsResponseModel
     */
    public function handle(ListTutorialsRequestModel $request)
    {
        $tutorials = $this->tutorialRepository->paging([
            'user_id', $request->userKey,
            'url', $request->url,
        ]);

        return new ListTutorialsResponseModel($tutorials);
    }
}