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
    public $tutorial_settings;

    /**
     * @var string
     */
    public $whitelistedDomainEntities;

    public function __construct(array $data)
    {
        $this->userKey = isset($data['userKey']) ?: null;
        $this->name = $data['name'];
        $this->domain = $data['domain'];
        $this->protocol = $data['protocol'];
        $this->tutorial_settings = $data['tutorial_settings'];
        $this->whitelistedDomainEntities = $data['whitelisted_domain_entities'];
    }

}
