<?php

namespace App\Usecases\GetProject;

class GetProjectRequestModel {

    /**
     * @var string
     */
    public $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }

}
