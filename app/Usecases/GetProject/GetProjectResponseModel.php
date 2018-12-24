<?php

namespace App\Usecases\GetProject;

class GetProjectResponseModel {

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $user_id;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->domain = $attributes['domain'];
        $this->user_id = $attributes['user_id'];
    }

}