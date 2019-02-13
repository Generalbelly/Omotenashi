<?php

namespace App\Usecases\StoreGoogleAnalyticsAccounts;

interface StoreGoogleAnalyticsAccountsUsecase {

    /**
     * @param StoreGoogleAnalyticsAccountsRequestModel $request
     * @return StoreGoogleAnalyticsAccountsResponseModel
     */
    public function handle(StoreGoogleAnalyticsAccountsRequestModel $request): StoreGoogleAnalyticsAccountsResponseModel;

}