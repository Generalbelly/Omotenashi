<?php

namespace App\Usecases\ListTutorials;

class ListTutorialsRequestModel {

    /**
     * @var string
     */
    public $userKey;

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
    public $orders;

    /**
     * @var string
     */
    public $page;

    /**
     * @var string
     */
    public $search;

    /**
     * @var string
     */
    public $perPage;

//    /**
//     * @var string
//     */
//    public $path;
//
//    /**
//     * @var string
//     */
//    public $query;

    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->userKey = $data['userKey'];

        $parsedUrl = parse_url($this->url);
        $this->domain = $parsedUrl['host'];
//        $this->path = $parsedUrl['path'];
//        $this->query = $parsedUrl['query'];
    }

}
