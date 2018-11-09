<?php

namespace App\Http\Controllers\API;

use App\Usecases\DeleteTutorial\DeleteTutorialRequestModel;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Usecases\ListTutorials\ListTutorialsRequestModel;
use App\Usecases\ListTutorials\ListTutorialsUsecase;
use App\Http\Requests\AddTutorialRequest;
use App\Usecases\AddTutorial\AddTutorialRequestModel;
use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Http\Requests\UpdateTutorialRequest;
use App\Usecases\UpdateTutorial\UpdateTutorialRequestModel;
use App\Usecases\UpdateTutorial\UpdateTutorialUsecase;
use App\Usecases\DeleteTutorial\DeleteTutorialUsecase;
use Log, Auth;

class TutorialController extends Controller
{
    private $listTutorialsUsecase;
    private $addTutorialUsecase;
    private $updateTutorialUsecase;
    private $deleteTutorialUsecase;

    public function __construct(
        ListTutorialsUsecase $listTutorialsUsecase,
        AddTutorialUsecase $addTutorialUsecase,
        UpdateTutorialUsecase $updateTutorialUsecase,
        DeleteTutorialUsecase $deleteTutorialUsecase
    ){
        $this->listTutorialsUsecase = $listTutorialsUsecase;
        $this->addTutorialUsecase = $addTutorialUsecase;
        $this->updateTutorialUsecase = $updateTutorialUsecase;
        $this->deleteTutorialUsecase = $deleteTutorialUsecase;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $url = $request->get('url');
        $userKey = $request->user()->key;
        $search = $request->get('q');
        $page = $request->get('page');
        $perPage = $request->get('per_page');

        $orders = [];
        $direction = $request->get('desc') === 'desc' ? 'desc' : 'asc';
        $column = $request->get('order_by');
        if ($direction && $column) {
            $orders = ['column' => $column, 'direction' => $direction];
        }

        $listTutorialsRequest = new ListTutorialsRequestModel([
            'url' => $url,
            'userKey' => $userKey,
            'orders' => $orders,
            'page' => $page,
            'search' => $search,
            'perPage' => $perPage,
        ]);
        $listTutorialsResponse = $this->listTutorialsUsecase->handle($listTutorialsRequest);

        return response()->json($listTutorialsResponse);
    }

    /**
     * @param AddTutorialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddTutorialRequest $request)
    {
        $addTutorialRequest = new AddTutorialRequestModel(array_merge(
            $request->all(),
            [
                'userKey' => $request->user()->key
            ]
        ));
        $addTutorialResponse = $this->addTutorialUsecase->handle($addTutorialRequest);

        return response()->json($addTutorialResponse);
    }

    /**
     * @param UpdateTutorialRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTutorialRequest $request, string $id)
    {
        $updateTutorialRequest = new UpdateTutorialRequestModel(array_merge(
            $request->all(),
            [
                'id' => $id,
                'userKey' => $request->user()->key
            ]
        ));
        $updateTutorialResponse = $this->updateTutorialUsecase->handle($updateTutorialRequest);

        return response()->json($updateTutorialResponse);
    }

    /**
     * @param UpdateTutorialRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $deleteTutorialRequest = new DeleteTutorialRequestModel(['id' => $id]);
        $deleteTutorialResponse = $this->deleteTutorialUsecase->handle($deleteTutorialRequest);

        return response()->json($deleteTutorialResponse);
    }
}
