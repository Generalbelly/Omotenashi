<?php

namespace App\Http\Controllers\API;

use App\Usecases\ListTutorials\ListTutorialsRequestModel;
use App\Usecases\ListTutorials\ListTutorialsUsecase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTutorialRequest;
use App\Usecases\AddTutorial\AddTutorialUsecase;
use App\Usecases\AddTutorial\AddTutorialRequestModel;
use Log, Auth;

class TutorialController extends Controller
{
    /**
     * @var AddTutorialUsecase
     */
    private $addTutorialUsecase;
    private $listTutorialsUsecase;

    public function __construct(
        AddTutorialUsecase $addTutorialUsecase,
        ListTutorialsUsecase $listTutorialsUsecase
    ){
        $this->addTutorialUsecase = $addTutorialUsecase;
        $this->listTutorialsUsecase = $listTutorialsUsecase;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = $request->get('url');
        $userKey = $request->user()->key;
        $search = $request->get('q');
        $page = $request->get('page');
        $perPage = $request->get('per_page');
        $orders = [
            ['column' => 'created_at', 'direction' => 'desc'],
        ];
        $direction = $request->get('desc') === 'desc' ? 'desc' : 'asc';
        $column = $request->get('order_by');
        if ($direction && $column) {
            $orders[] = ['column' => $column, 'direction' => $direction];
        }

        $listTutorialsRequest = new ListTutorialsRequestModel([
            'url' => $url,
            'user_id' => $userKey,
            'orders' => $orders,
            'page' => $page,
            'search' => $search,
            'perPage' => $perPage,
        ]);
        $listTutorialsResponse = $this->listTutorialsUsecase($listTutorialsRequest);

        return response()->json($listTutorialsResponse);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddTutorialRequest  $request
     * @return \Illuminate\Http\Response
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
