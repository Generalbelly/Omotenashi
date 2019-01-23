<?php

namespace App\Http\Controllers;

use App\Usecases\AddOAuth\AddOAuthRequestModel;
use App\Usecases\AddOAuth\AddOAuthUsecaseInteractor;
use Illuminate\Http\Request;

class OAuthController extends Controller
{

    private $addOAuthUsecase;

    public function __construct(AddOAuthUsecaseInteractor $addOAuthUsecase)
    {
        $this->addOAuthUsecase = $addOAuthUsecase;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleAnalticsRedirect()
    {
        $addOAuthRequest = new AddOAuthRequestModel([

        ])
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
     */
    public function googleAnalticsCallback(Request $httpRequest)
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
