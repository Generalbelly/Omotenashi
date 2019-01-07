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
     * @var string
     */
    public $whitelisted_domain_entities;

    public function __construct(array $attributes)
    {
        $this->id = $attributes['id'];
        $this->name = $attributes['name'];
        $this->domain = $attributes['domain'];
        $this->protocol = $attributes['protocol'];
        $this->user_id = $attributes['user_id'];
        $this->whitelisted_domain_entities = $attributes['whitelisted_domain_entities'];
    }

}