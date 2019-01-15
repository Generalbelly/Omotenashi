<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OAuthController extends Controller
{
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Domains\Entities\Exceptions\SiloException
     */
    public function googleAdsRedirect()
    {
        $requestStruct = new RedirectOauthRequestStruct([
            'medium' => MediaObject::GOOGLE_ADS['medium'],
        ]);
        /** @var \App\Domains\UseCases\RedirectOauth\RedirectOauthResponseStruct $responseStrucgt */
        $responseStruct = RedirectOauthUseCase::handle($requestStruct);
        Session::flash('oauth2state', $responseStruct->get('state'));
        return redirect()->to($responseStruct->get('url'));
    }

    /**
     * @param Request $httpRequest
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Domains\Entities\Exceptions\SiloException
     */
    public function googleAdsCallback(Request $httpRequest)
    {
        $error = $httpRequest->get('error', false);
        if($error) {
            return redirect()->route('oauths.create');
        }
        $state = $httpRequest->get('state', false);
        if($state == false || Session::get('oauth2state') != $state) {
            return redirect()->route('oauths.create');
        }
        $requestStruct = new AddOauthRequestStruct([
            'agencyID' => $httpRequest->user()->agencyEntity->getAttribute('id'),
            'medium'   => MediaObject::GOOGLE_ADS['medium'],
            'code'     => $httpRequest->get('code'),
        ]);
        AddOauthUseCase::handle($requestStruct);
        return redirect()->route('oauths.index');
    }

}
