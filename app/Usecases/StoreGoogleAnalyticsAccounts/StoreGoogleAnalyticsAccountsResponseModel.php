<?php

namespace App\Usecases\StoreGoogleAnalyticsAccounts;

class StoreGoogleAnalyticsAccountsResponseModel {

    /** @var string */
    public $project_id;

    public function __construct(array $attributes)
    {
        $this->project_id = $attributes['project_id'];
    }

}