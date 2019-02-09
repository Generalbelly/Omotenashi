<?php

namespace App\Usecases\AddOAuth;

class AddOAuthRequestModel {

    /** @var string */
    public $code;

    /** @var string */
    public $service;

    /** @var string */
    public $project_id;

    public function __construct(array $data)
    {
        $this->code = $data['code'];
        $this->service = $data['service'];
        $this->project_id = $data['project_id'];
    }

}
