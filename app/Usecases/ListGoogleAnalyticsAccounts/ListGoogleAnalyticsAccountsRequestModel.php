<?php

namespace App\Usecases\ListGoogleAnalyticsAccounts;
use Log;

class ListGoogleAnalyticsAccountsRequestModel {

    /**
     * @var string
     */
    public $project_id;

    public function __construct(array $data)
    {
        $this->project_id = $data['project_id'];
    }

}
