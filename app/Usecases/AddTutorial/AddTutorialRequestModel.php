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

    /**
     * @var string
     */
    public $query;

    public function __construct(array $data)
    {
        $this->userKey = $data['userKey'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->steps = $data['steps'];
        $this->url = $data['url'];
        $this->user_id = $data['user_id'];

        $parsedUrl = parse_url($this->url);
        $this->domain = $parsedUrl['host'];
//        $this->path = $parsedUrl['path'];
//        $this->query = $parsedUrl['query'];
    }

}
