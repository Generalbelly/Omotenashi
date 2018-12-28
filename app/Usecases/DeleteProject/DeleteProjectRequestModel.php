<?php

namespace App\Usecases\DeleteProject;

class DeleteProjectRequestModel {

    /**
     * @var string
     */
    public $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }

}
