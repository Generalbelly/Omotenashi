<?php

namespace App\Usecases\AddTutorial;

class AddTutorialRequestModel {

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
    public $description;

    /**
     * @var string
     */
    public $steps;

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $parameters;

    /**
     * @var string
     */
    public $project_id;

    public function __construct(array $data)
    {
        $this->userKey = $data['userKey'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->steps = $data['steps'];
        $this->path = array_merge(
            $data['path'],
            [
                'deepness' => $data['path']['value'] === '/' ? 0 : count(explode('/', $data['path']['value'])) - 1,
            ]
        );
        $this->parameters = $data['parameters'];
        $this->project_id = isset($data['project_id']) ? $data['project_id'] : null;
    }

}
