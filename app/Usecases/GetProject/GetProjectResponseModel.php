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
    public $protocol;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var array
     */
    public $whitelisted_domain_entities;

    /**
     * @var array
     */
    public $oauth_entities;

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
        $this->user_id = $attributes['user_id'];
        $this->whitelisted_domain_entities = array_get($attributes, 'whitelisted_domain_entities', []);
        $this->oauth_entities = array_get($attributes, 'oauth_entities', []);
        $this->created_at = $attributes['created_at'];
        $this->updated_at = $attributes['updated_at'];
    }

}