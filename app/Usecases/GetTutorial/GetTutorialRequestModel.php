<?php

namespace App\Usecases\GetTutorial;

use Log;

class GetTutorialRequestModel {

    /**
     * @var string
     */
    public $userKey;

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $page;

    /**
     * @var string
     */
    public $path;

    /**
     * @var string
     */
    public $query;

    /**
     * @var int
     */
    public $deepness;

    public function __construct(array $data)
    {
        $this->userKey = $data['userKey'];
        $parsedUrl = parse_url($data['url']);
        $this->domain = $parsedUrl['host'];
        $this->path = $parsedUrl['path'];
        $this->query = isset($parsedUrl['query']) ? $parsedUrl['query'] : null;
        $this->deepness = $parsedUrl['path'] === '/' ? 0 : count(explode('/', $parsedUrl['path'])) - 1;
    }

}
