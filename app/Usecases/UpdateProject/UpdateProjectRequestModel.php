<?php

namespace App\Usecases\UpdateProject;

class UpdateProjectRequestModel {

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
    public $whitelistedDomainEntities;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->domain = $data['domain'];
        $this->protocol = $data['protocol'];
        $this->whitelistedDomainEntities = $data['whitelisted_domain_entities'];
    }

}
