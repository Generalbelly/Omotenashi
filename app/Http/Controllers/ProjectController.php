<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usecases\ListProjects\ListProjectsUsecase;
use App\Usecases\ListProjects\ListProjectsRequestModel;

class ProjectController extends Controller
{
    private $listProjectsUsecase;
//    private $addProjectUsecase;
//    private $updateProjectUsecase;
//    private $deleteProjectUsecase;

    public function __construct(
        ListProjectsUsecase $listProjectsUsecase
//        AddProjectUsecase $addProjectUsecase,
//        UpdateProjectUsecase $updateProjectUsecase,
//        DeleteProjectUsecase $deleteProjectUsecase
    ){
        $this->listProjectsUsecase = $listProjectsUsecase;
//        $this->addProjectUsecase = $addProjectUsecase;
//        $this->updateProjectUsecase = $updateProjectUsecase;
//        $this->deleteProjectUsecase = $deleteProjectUsecase;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
