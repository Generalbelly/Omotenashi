<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTutorialRequest;
use App\Usecases\AddTutorialUsecase\AddTutorialUsecase;
use App\Usecases\AddTutorialUsecase\AddTutorialRequestModel;
use Log, Auth;

class TutorialController extends Controller
{
    /**
     * @var AddTutorialUsecase
     */
    private $addTutorialUsecase;

    public function __construct(AddTutorialUsecase $addTutorialUsecase)
    {
        $this->addTutorialUsecase = $addTutorialUsecase;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddTutorialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTutorialRequest $request)
    {
        Log::error('controller');
        Log::error(Auth::user());
        $addTutorialRequest = new AddTutorialRequestModel($request->all());
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
