<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usecases\ListProjects\ListProjectsUsecase;
use App\Usecases\ListProjects\ListProjectsRequestModel;
use Log;

class ProjectController extends Controller
{
    private $listProjectsUsecase;
//    private $addProjectUsecase;
//    private $updateProjectUsecase;
//    private $deleteProjectUsecase;

    /**
     * ProjectController constructor.
     * @param ListProjectsUsecase $listProjectsUsecase
     */
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
        Log::error($orders);
        $listProjectsResponse = $this->listProjectsUsecase->handle($listProjectsRequest);

        if ($request->isXmlHttpRequest()) {
            return response()->json($listProjectsResponse);
        } else {
            return view('dashboard');
        }

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
