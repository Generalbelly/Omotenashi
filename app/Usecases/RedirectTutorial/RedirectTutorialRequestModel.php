<?php

namespace App\Usecases\RedirectTutorial;

class RedirectTutorialRequestModel {

    /** @var string */
    public $projectId;

    /** @var string */
    public $id;

    public function __construct(array $data)
    {
        $this->projectId = $data['projectId'];
        $this->id = $data['id'];
    }

}
