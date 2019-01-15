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
     * @var string
     */
    public $query;

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
        $this->project_id = $data['project_id'];

        $parsedUrl = parse_url($data['url']);
        $this->domain = $parsedUrl['host'];
        $this->path = $parsedUrl['path'];
        $this->query = isset($parsedUrl['query']) ? $parsedUrl['query'] : null;
    }

}
