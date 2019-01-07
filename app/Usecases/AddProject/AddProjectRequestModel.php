<?php

namespace App\Usecases\AddProject;

class AddProjectRequestModel {

    /**
     * @var string
     */
    public $userKey;

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
        $this->userKey = $data['userKey'];
        $this->name = $data['name'];
        $this->domain = $data['domain'];
        $this->protocol = $data['protocol'];
        $this->whitelistedDomainEntities = $data['whitelisted_domain_entities'];
    }

}
