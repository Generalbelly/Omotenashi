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
    public $protocol;

    /**
     * @var string
     */
    public $tutorial_settings;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var array
     */
    public $whitelisted_domain_entities;

    /**
     * @var string
     */
    public $created_at;

    /**
     * @var string
     */
    public $updated_at;


    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->domain = $attributes['domain'];
        $this->protocol = $attributes['protocol'];
        $this->tutorial_settings = $attributes['tutorial_settings'];
        $this->user_id = $attributes['user_id'];
        $this->whitelisted_domain_entities = array_get($attributes, 'whitelisted_domain_entities', []);
        $this->updated_at = $attributes['updated_at'];
        $this->created_at = $attributes['created_at'];
    }

}