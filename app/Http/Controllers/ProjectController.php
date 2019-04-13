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
use DB;
use Session;


class ProjectController extends Controller
{

    public function index(ListProjectsUsecase $listProjectsUsecase, Request $request)
    {
        if ($request->isXmlHttpRequest() === false) {
            return view('dashboard');
        }

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
        $listProjectsRequest = new ListProjectsRequestModel([
            'userKey' => $userKey,
            'orders' => $orders,
            'page' => $page,
            'search' => $search,
            'perPage' => $perPage,
        ]);

        DB::beginTransaction();
        try {
            $listProjectsResponse = $listProjectsUsecase->handle($listProjectsRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json($listProjectsResponse);
    }

    public function create()
    {
        return view('dashboard');
    }

    public function store(AddProjectUsecase $addProjectUsecase, AddProjectRequest $request)
    {
        $addProjectRequest = new AddProjectRequestModel(array_merge(
            $request->all(),
            [
                'userKey' => $request->user()->key
            ]
        ));

        DB::beginTransaction();
        try {
            $addProjectResponse = $addProjectUsecase->handle($addProjectRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json($addProjectResponse);
    }

    public function show(GetProjectUsecase $getProjectUsecase, Request $request, string $id)
    {
        if ($request->isXmlHttpRequest() === false) {
            return view('dashboard');
        }

        $getProjectRequest = new GetProjectRequestModel([
            'id' => $id,
        ]);

        DB::beginTransaction();
        try {
            $getProjectResponse = $getProjectUsecase->handle($getProjectRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if (Session::has('oauthError') && Session::get('oauthError')) {
            return response()->json($getProjectResponse, 500);
        }

        return response()->json($getProjectResponse);
    }

    public function edit(string $id)
    {
        return view('dashboard');
    }

    public function update(UpdateProjectUsecase $updateProjectUsecase, UpdateProjectRequest $request, string $id)
    {
        $updateProjectRequest = new UpdateProjectRequestModel(array_merge(
            $request->all(),
            [
                'id' => $id,
            ]
        ));

        DB::beginTransaction();
        try {
            $updateProjectResponse = $updateProjectUsecase->handle($updateProjectRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json($updateProjectResponse);
    }

    public function destroy(DeleteProjectUsecase $deleteProjectUsecase, string $id)
    {
        $deleteProjectRequest = new DeleteProjectRequestModel(array_merge(
            [
                'id' => $id,
            ]
        ));

        DB::beginTransaction();
        try {
            $deleteProjectResponse = $deleteProjectUsecase->handle($deleteProjectRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json($deleteProjectResponse);
    }
}
