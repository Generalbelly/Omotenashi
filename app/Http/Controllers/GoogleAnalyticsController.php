<?php

namespace App\Http\Controllers;

use App\Usecases\ListGoogleAnalyticsAccounts\ListGoogleAnalyticsAccountsRequestModel;
use App\Usecases\ListGoogleAnalyticsAccounts\ListGoogleAnalyticsAccountsUsecase;
use Illuminate\Http\Request;
use DB;
use Session;
use Exception;


class GoogleAnalyticsController extends Controller
{

    private $listGoogleAnalyticsAccountsUsecase;

    public function __construct(
        ListGoogleAnalyticsAccountsUsecase $listGoogleAnalyticsAccountsUsecase
    )
    {
        $this->listGoogleAnalyticsAccountsUsecase = $listGoogleAnalyticsAccountsUsecase;
    }

    public function index(Request $request, string $project_id)
    {
        DB::beginTransaction();

        try {
            $listGoogleAnalyticsAccountsRequest = new ListGoogleAnalyticsAccountsRequestModel([
                'project_id' => $project_id
            ]);
            $listGoogleAnalyticsAccountsResponse = $this->listGoogleAnalyticsAccountsUsecase->handle(
                $listGoogleAnalyticsAccountsRequest
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($listGoogleAnalyticsAccountsResponse);
    }
}
