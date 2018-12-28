<?php

namespace App\Usecases\AddProject;

class AddProjectResponseModel {

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

    /**
     * @var string
     */
    public $created_at;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->domain = $attributes['domain'];
        $this->user_id = $attributes['user_id'];
        $this->created_at = $attributes['created_at'];
    }

}