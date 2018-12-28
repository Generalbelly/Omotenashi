<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use App\Usecases\ListProjects\ListProjectsRequestModel;
use App\Usecases\ListProjects\ListProjectsUsecase;

use App\Usecases\AddProject\AddProjectRequestModel;
use App\Usecases\AddProject\AddProjectUsecase;

use App\Usecases\GetProject\GetProjectRequestModel;
use App\Usecases\GetProject\GetProjectUsecase;

use App\Usecases\UpdateProject\UpdateProjectRequestModel;
use App\Usecases\UpdateProject\UpdateProjectUsecase;

use App\Usecases\DeleteProject\DeleteProjectRequestModel;
use App\Usecases\DeleteProject\DeleteProjectUsecase;

use Exception;

class ProjectController extends Controller
{
    private $listProjectsUsecase;
    private $addProjectUsecase;
    private $getProjectUsecase;
    private $updateProjectUsecase;
    private $deleteProjectUsecase;

    /**
     * ProjectController constructor.
     * @param ListProjectsUsecase $listProjectsUsecase
     * @param AddProjectUsecase $addProjectUsecase
     * @param GetProjectUsecase $getProjectUsecase
     * @param UpdateProjectUsecase $updateProjectUsecase
     * @param DeleteProjectUsecase $deleteProjectUsecase
     */
    public function __construct(
        ListProjectsUsecase $listProjectsUsecase,
        AddProjectUsecase $addProjectUsecase,
        GeTProjectUsecase $getProjectUsecase,
        UpdateProjectUsecase $updateProjectUsecase,
        DeleteProjectUsecase $deleteProjectUsecase
    ){
        $this->listProjectsUsecase = $listProjectsUsecase;
        $this->addProjectUsecase = $addProjectUsecase;
        $this->getProjectUsecase = $getProjectUsecase;
        $this->updateProjectUsecase = $updateProjectUsecase;
        $this->deleteProjectUsecase = $deleteProjectUsecase;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest() === false) {
            return view('dashboard');
        }

        $url = $request->query('url');
        $userKey = $request->user()->key;
        $search = $request->query('q');
        $page = $request->query('page', 0);
        $perPage = $request->query('perPage', 20);

        $orderBy = $request->query('orderBy', null);
        $orders = [];
        if (isset($orderBy)) {
            foreach (explode(',', $orderBy) as $order) {
                $orderArray = explode(' ', $order);
                $orders[] = ['column' => $orderArray[0], 'direction' => $orderArray[1]];
            }
        }
        $listProjectsRequest = new ListProjectsRequestModel([
            'url' => $url,
            'userKey' => $userKey,
            'orders' => $orders,
            'page' => $page,
            'search' => $search,
            'perPage' => $perPage,
        ]);

        try {
            $listProjectsResponse = $this->listProjectsUsecase->handle($listProjectsRequest);
        } catch (Exception $e) {
            throw $e;
        }
        return response()->json($listProjectsResponse);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard');
    }

    /**
     * @param AddProjectRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function store(AddProjectRequest $request)
    {
        $addProjectRequest = new AddProjectRequestModel(array_merge(
            $request->all(),
            [
                'userKey' => $request->user()->key
            ]
        ));
        $addProjectResponse = $this->addProjectUsecase->handle($addProjectRequest);

        return response()->json($addProjectResponse);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        if ($request->isXmlHttpRequest() === false) {
            return view('dashboard');
        }

        $getProjectRequest = new GetProjectRequestModel([
            'id' => $id,
        ]);

        $getProjectResponse = $this->getProjectUsecase->handle($getProjectRequest);

        return response()->json($getProjectResponse);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('dashboard');
    }

    /**
     * @param UpdateProjectRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $updateProjectRequest = new UpdateProjectRequestModel(array_merge(
            $request->all(),
            [
                'id' => $id,
            ]
        ));
        $updateProjectResponse = $this->updateProjectUsecase->handle($updateProjectRequest);

        return response()->json($updateProjectResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProjectRequest = new DeleteProjectRequestModel(array_merge(
            [
                'id' => $id,
            ]
        ));
        $deleteProjectResponse = $this->deleteProjectUsecase->handle($deleteProjectRequest);

        return response()->json($deleteProjectResponse);
    }
}
