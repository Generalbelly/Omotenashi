<?php

namespace App\Usecases\ListProjects;

class ListProjectsResponseModel {

    public $total;
    public $start;
    public $end;
    public $entities;

    public function __construct(array $attributes)
    {
        $this->total = $attributes['total'];
        $this->start = $attributes['start'];
        $this->end = $attributes['end'];
        $this->entities = $attributes['entities'];
    }

}