<?php

namespace App\Usecases\UpdateTutorial;

use App\Usecases\AddTutorial\AddTutorialRequestModel;

class UpdateTutorialRequestModel extends AddTutorialRequestModel {

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
