<?php

namespace App\Usecases\ListGoogleAnalyticsAccounts;

interface ListGoogleAnalyticsAccountsUsecase {

    /**
     * @param ListGoogleAnalyticsAccountsRequestModel $request
     * @return ListGoogleAnalyticsAccountsResponseModel
     */
    public function handle(ListGoogleAnalyticsAccountsRequestModel $request): ListGoogleAnalyticsAccountsResponseModel;

}