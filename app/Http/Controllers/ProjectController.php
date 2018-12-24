<?php

namespace App\Http\Controllers;

use App\Usecases\GetProject\GetProjectRequestModel;
use Illuminate\Http\Request;
use App\Http\Requests\AddProjectRequest;
use App\Usecases\ListProjects\ListProjectsRequestModel;
use App\Usecases\ListProjects\ListProjectsUsecase;
use App\Usecases\AddProject\AddProjectRequestModel;
use App\Usecases\AddProject\AddProjectUsecase;
use App\Usecases\GetProject\GetProjectUsecase;
use App\Usecases\UpdateProject\UpdateProjectUsecase;
use Log;

class ProjectController extends Controller
{
    private $listProjectsUsecase;
    private $addProjectUsecase;
    private $getProjectUsecase;
//    private $updateProjectUsecase;
//    private $deleteProjectUsecase;

    /**
     * ProjectController constructor.
     * @param ListProjectsUsecase $listProjectsUsecase
     * @param AddProjectUsecase $addProjectUsecase
     */
    public function __construct(
        ListProjectsUsecase $listProjectsUsecase,
        AddProjectUsecase $addProjectUsecase,
        GeTProjectUsecase $getProjectUsecase,
        UpdateProjectUsecase $updateProjectUsecase
//        DeleteProjectUsecase $deleteProjectUsecase
    ){
        $this->listProjectsUsecase = $listProjectsUsecase;
        $this->addProjectUsecase = $addProjectUsecase;
        $this->getProjectUsecase = $getProjectUsecase;
        $this->updateProjectUsecase = $updateProjectUsecase;
//        $this->deleteProjectUsecase = $deleteProjectUsecase;
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

        $orderBy = $request->query('orderBy');
        $orders = [];
        if (!is_null($orderBy)) {
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
        $listProjectsResponse = $this->listProjectsUsecase->handle($listProjectsRequest);

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
        if ($request->isXmlHttpRequest() === false) {
            return view('dashboard');
        }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
