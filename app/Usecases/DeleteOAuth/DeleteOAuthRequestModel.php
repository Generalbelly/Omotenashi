<?php

namespace App\Usecases\DeleteOAuth;

class DeleteOAuthRequestModel {

    /** @var string */
    public $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }

}
