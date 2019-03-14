<?php

namespace App\Usecases\ListTutorials;
use Log;

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

    /**
     * @var string
     */
    public $path;

    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->userKey = $data['userKey'];
        $this->orders = $data['orders'];
        $this->page = $data['page'];
        $this->search = $data['search'];
        $this->perPage = $data['perPage'];
        $this->domain = $data['domain'];
        $this->path = $data['path'];
    }

}
