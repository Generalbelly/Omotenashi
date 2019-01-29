<?php

namespace App\Http\Controllers;

use App\Domains\Models\OAuthService;
use App\Usecases\AddOAuth\AddOAuthUsecaseInteractor;
use App\Usecases\RedirectOAuth\RedirectOAuthRequestModel;
use App\Usecases\RedirectOAuth\RedirectOAuthUsecaseInteractor;
use Illuminate\Http\Request;
use Session;

class OAuthController extends Controller
{

    private $addOAuthUsecase;
    private $redirectOAuthUsecase;

    public function __construct(
        AddOAuthUsecaseInteractor $addOAuthUsecase,
        RedirectOAuthUsecaseInteractor $redirectOAuthUsecase
    )
    {
        $this->addOAuthUsecase = $addOAuthUsecase;
        $this->redirectOAuthUsecase = $redirectOAuthUsecase;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function googleAnalyticsRedirect()
    {
        $redirectOAuthRequest = new RedirectOAuthRequestModel([
            'service' => OAuthService::GOOGLE_ANALYTICS,
        ]);
        $redirectOAuthResponse = $this->redirectOAuthUsecase->handle($redirectOAuthRequest);
        Session::flash('oauth2state', $redirectOAuthResponse->state);
        return redirect()->to($redirectOAuthResponse->url);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function googleAnalyticsCallback(Request $request)
    {
        $error = $request->get('error', false);
        if($error) {
            return redirect()->route('oauths.create');
        }
        $state = $request->get('state', false);
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
