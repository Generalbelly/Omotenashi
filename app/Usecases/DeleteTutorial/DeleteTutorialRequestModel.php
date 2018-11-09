<?php

namespace App\Usecases\DeleteTutorial;

class DeleteTutorialRequestModel {

    /**
     * @var string
     */
    public $id;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
    }

}
