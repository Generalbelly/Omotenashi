<?php

namespace App\Usecases\UpdateProject;

use App\Usecases\AddProject\AddProjectRequestModel;

class UpdateProjectRequestModel extends AddProjectRequestModel {

    /**
     * @var string
     */
    public $id;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->id = $data['id'];
    }

}
