<?php

namespace App\Usecases\AddOAuth;

class AddOAuthRequestModel {

    /** @var string */
    public $code;

    public function __construct(array $data)
    {
        $this->code = $data['code'];
    }

}
