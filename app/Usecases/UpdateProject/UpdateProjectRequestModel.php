<?php

namespace App\Usecases\UpdateProject;

use App\Usecases\AddProject\AddProjectRequestModel;

class UpdateProjectRequestModel extends AddProjectRequestModel {

    /**
     * @var string
     */
    public $id;

    /**
     * @var array
     */
    public $googleAnalyticsPropertyEntities;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->id = $data['id'];
        $this->googleAnalyticsPropertyEntities = $data['google_analytics_property_entities'];
    }

}
