<?php

namespace App\Usecases\DeleteOAuth;

class DeleteOAuthResponseModel {

    /** @var string */
    public $id;
    
    /** @var string */
    public $project_id;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->project_id = $attributes['project_id'];
    }

}