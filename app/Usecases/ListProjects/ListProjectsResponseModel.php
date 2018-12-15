<?php

namespace App\Usecases\ListProjects;

class ListProjectsResponseModel {

    public $total;
    public $entities;

    public function __construct(array $attributes)
    {
        $this->total = $attributes['total'];
        $this->entities = $attributes['entities'];
    }

}