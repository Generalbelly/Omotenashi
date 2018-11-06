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
    public $url;

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $path;

    public function __construct(array $data)
    {
        $this->userKey = $data['userKey'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->steps = $data['steps'];
        $this->url = $data['url'];

        $parsedUrl = parse_url($this->url);
        $this->domain = $parsedUrl['host'];
        $this->path = $parsedUrl['path'];
    }

}
