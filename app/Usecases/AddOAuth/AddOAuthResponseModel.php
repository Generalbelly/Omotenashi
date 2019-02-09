<?php

namespace App\Usecases\AddOAuth;

class AddOAuthResponseModel {

    /** @var string */
    public $project_id;

    public function __construct(array $attributes)
    {
        $this->project_id = $attributes['project_id'];
    }

}