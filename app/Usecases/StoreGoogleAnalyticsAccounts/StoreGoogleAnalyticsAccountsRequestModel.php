<?php

namespace App\Usecases\StoreGoogleAnalyticsAccounts;

class StoreGoogleAnalyticsAccountsRequestModel {

    /** @var string */
    public $project_id;

    public function __construct(array $data)
    {
        $this->project_id = $data['project_id'];
    }

}
