<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Usecases\ListTutorials\ListTutorialsRequestModel;
use App\Usecases\ListTutorials\ListTutorialsUsecase;
use App\Usecases\GetTutorial\GetTutorialRequestModel;
use App\Usecases\GetTutorial\GetTutorialUsecase;
use App\Http\Requests\AddTutorialRequest;
use App\Usecases\AddTutorial\AddTutorialRequestModel;
use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Http\Requests\UpdateTutorialRequest;
use App\Usecases\UpdateTutorial\UpdateTutorialRequestModel;
use App\Usecases\UpdateTutorial\UpdateTutorialUsecase;
use App\Usecases\DeleteTutorial\DeleteTutorialRequestModel;
use App\Usecases\DeleteTutorial\DeleteTutorialUsecase;
use Exception;
use DB;

class TutorialController extends Controller
{
    private $listTutorialsUsecase;
    private $getTutorialUsecase;
    private $addTutorialUsecase;
    private $updateTutorialUsecase;
    private $deleteTutorialUsecase;

    public function __construct(
        ListTutorialsUsecase $listTutorialsUsecase,
        GetTutorialUsecase $getTutorialUsecase,
        AddTutorialUsecase $addTutorialUsecase,
        UpdateTutorialUsecase $updateTutorialUsecase,
        DeleteTutorialUsecase $deleteTutorialUsecase
    ){
        $this->listTutorialsUsecase = $listTutorialsUsecase;
        $this->getTutorialUsecase = $getTutorialUsecase;
        $this->addTutorialUsecase = $addTutorialUsecase;
        $this->updateTutorialUsecase = $updateTutorialUsecase;
        $this->deleteTutorialUsecase = $deleteTutorialUsecase;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $request->validate([
            'url' => 'url',
        ]);

        $url = $request->query('url');
        $userKey = $request->user()->key;
        $search = $request->query('q');
        $page = $request->query('page', 0);
        $perPage = $request->query('perPage', 20);

        $orderBy = $request->query('orderBy', null);
        $orders = [
            [
                'column' => 'created_at',
                'direction' => 'desc'
            ],
        ];
        if (isset($orderBy)) {
            foreach (explode(',', $orderBy) as $order) {
                $orderArray = explode(' ', $order);
                $orders[] = ['column' => $orderArray[0], 'direction' => $orderArray[1]];
            }
        }

        $listTutorialsRequest = new ListTutorialsRequestModel([
            'url' => $url,
            'userKey' => $userKey,
            'orders' => $orders,
            'page' => $page,
            'search' => $search,
            'perPage' => $perPage,
        ]);

        DB::beginTransaction();
        try {
            $listTutorialsResponse = $this->listTutorialsUsecase->handle($listTutorialsRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($listTutorialsResponse);
    }

    public function show(Request $request, string $userKey)
    {
        $url = $request->query('url');

        $getTutorialRequest = new GetTutorialRequestModel([
            'url' => $url,
            'userKey' => $userKey,
        ]);

        DB::beginTransaction();
        try {
            $getTutorialResponse = $this->getTutorialUsecase->handle($getTutorialRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($getTutorialResponse);
    }

    /**
     * @param AddTutorialRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function store(AddTutorialRequest $request)
    {
        $addTutorialRequest = new AddTutorialRequestModel(array_merge(
            $request->all(),
            [
                'userKey' => $request->user()->key
            ]
        ));

        DB::beginTransaction();
        try {
            $addTutorialResponse = $this->addTutorialUsecase->handle($addTutorialRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($addTutorialResponse);
    }

    /**
     * @param UpdateTutorialRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
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

        DB::beginTransaction();
        try {
            $updateTutorialResponse = $this->updateTutorialUsecase->handle($updateTutorialRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($updateTutorialResponse);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function destroy(string $id)
    {
        $deleteTutorialRequest = new DeleteTutorialRequestModel(['id' => $id]);
        DB::beginTransaction();
        try {
            $deleteTutorialResponse = $this->deleteTutorialUsecase->handle($deleteTutorialRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($deleteTutorialResponse);
    }
}
