<?php

namespace App\Http\Controllers;

use App\Domains\Models\OAuth\OAuthService;
use App\Usecases\AddOAuth\AddOAuthUsecase;
use App\Usecases\AddOAuth\AddOAuthRequestModel;
use App\Usecases\DeleteOAuth\DeleteOAuthRequestModel;
use App\Usecases\DeleteOAuth\DeleteOAuthUsecase;
use App\Usecases\RedirectOAuth\RedirectOAuthRequestModel;
use App\Usecases\RedirectOAuth\RedirectOAuthUsecase;
use Illuminate\Http\Request;
use Session;
use DB;
use Exception;


class OAuthController extends Controller
{

    private $addOAuthUsecase;
    private $redirectOAuthUsecase;
    private $deleteOAuthUsecase;

    public function __construct(
        AddOAuthUsecase $addOAuthUsecase,
        RedirectOAuthUsecase $redirectOAuthUsecase,
        DeleteOAuthUsecase $deleteOAuthUsecase
    )
    {
        $this->addOAuthUsecase = $addOAuthUsecase;
        $this->redirectOAuthUsecase = $redirectOAuthUsecase;
        $this->deleteOAuthUsecase = $deleteOAuthUsecase;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function googleAnalyticsRedirect(Request $request)
    {
        Session::flash('projectId', $request->get('id'));

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
     * @throws \Exception
     */
    public function googleAnalyticsCallback(Request $request)
    {
        $projectId = Session::get('projectId', null);

        $oauthError = false;

        $error = $request->get('error', false);
        if($error || !$projectId) {
            $oauthError = true;
        }

        $state = $request->get('state', false);
        if($state == false || Session::get('oauth2state') != $state) {
            $oauthError = true;
        }

        if ($oauthError) {
            Session::flash('oauthError', $oauthError);
            return redirect()->route('projects.show', [
                'id' => $projectId,
            ]);
        }

        DB::beginTransaction();

        try {
            $addOAuthRequest = new AddOAuthRequestModel([
                'code'     => $request->get('code'),
                'service' => OAuthService::GOOGLE_ANALYTICS,
                'project_id' => $projectId,
            ]);

            $addOAuthResponse = $this->addOAuthUsecase->handle($addOAuthRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('projects.show', [
            'id' => $addOAuthResponse->project_id,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $deleteOAuthRequest = new DeleteOAuthRequestModel([
            'id' => $id,
        ]);

        DB::beginTransaction();
        try {
            $deleteOAuthResponse = $this->deleteOAuthUsecase->handle($deleteOAuthRequest);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json($deleteOAuthResponse);
    }

}
