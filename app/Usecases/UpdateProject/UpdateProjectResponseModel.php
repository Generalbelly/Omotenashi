<?php

namespace App\Usecases\UpdateProject;

use App\Usecases\AddProject\AddProjectResponseModel;

class UpdateProjectResponseModel extends AddProjectResponseModel {

    /**
     * @var array
     */
    public $oauth_entities;

    /**
     * @var array
     */
    public $google_analytics_property_entities;


    public function __construct(array $attributes)
    {
        $this->oauth_entities = array_get($attributes, 'oauth_entities', []);
        $this->google_analytics_property_entities = array_get($attributes, 'google_analytics_property_entities', []);
        parent::__construct($attributes);
    }

}