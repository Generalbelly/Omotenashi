<?php

namespace App\Usecases\ListGoogleAnalyticsAccounts;

class ListGoogleAnalyticsAccountsResponseModel {

    /** @var string */
    public $project_id;
    public $accounts;

    public function __construct(array $attributes)
    {
        $this->project_id = $attributes['project_id'];
        $this->accounts = $attributes['accounts'];
    }

}