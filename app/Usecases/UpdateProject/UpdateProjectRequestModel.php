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
     * @var array
     */
    public $whitelistedDomainEntities;

    /**
     * @var array
     */
    public $googleAnalyticsPropertyEntities;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->domain = $data['domain'];
        $this->protocol = $data['protocol'];
        $this->whitelistedDomainEntities = $data['whitelisted_domain_entities'];
        $this->googleAnalyticsPropertyEntities = $data['google_analytics_property_entities'];
    }

}
