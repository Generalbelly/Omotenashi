<?php

namespace App\Usecases\RedirectOAuth;

class RedirectOAuthRequestModel {

    /** @var string */
    public $service;

    public function __construct(array $data)
    {
        $this->service = $data['service'];
    }

}
