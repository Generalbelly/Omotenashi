<?php

namespace App\Usecases\ListProjects;

class ListProjectsRequestModel {

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
        $this->userKey = $data['userKey'];
        $this->orders = $data['orders'];
        $this->page = $data['page'];
        $this->search = $data['search'];
        $this->perPage = $data['perPage'];
    }

}
