<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usecases\CreateTutorialUsecase\CreateTutorialUsecase;
use App\Usecases\CreateTutorialUsecase\CreateTutorialRequest;

class TutorialController extends Controller
{
    /**
     * @var CreateTutorialUsecase
     */
    private $createUsecase;

    public function __construct(CreateTutorialUsecase $createUsecase)
    {
        $this->createUsecase = $createUsecase;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $createTutorialRequest = new CreateTutorialRequest($request->all());
        $createTutorialResponse = $this->createUsecase->handle($createTutorialRequest);

        return response()->json($createTutorialResponse);
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
