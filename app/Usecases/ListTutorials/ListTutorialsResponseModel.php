<?php

namespace App\Usecases\ListTutorials;

class ListTutorialsResponseModel {

    public $total;
    public $start;
    public $end;
    public $projectEntity;
    public $tutorialEntities;

    public function __construct(array $attributes)
    {
        $projectEntity = $attributes['projectEntity'];
        $this->total = $attributes['total'];
        $this->start = $attributes['start'];
        $this->end = $attributes['end'];
        $this->projectEntity = $projectEntity;
        $this->tutorialEntities = [];

        foreach ($attributes['entities'] as $entity) {
            $entity['url'] = $projectEntity['protocol'].'://'.$projectEntity['domain'].$entity['path'];
            $entity['url'] .= $entity['query'] ? '?'.$entity['query'] : '';
            $this->tutorialEntities[] = $entity;
        }
    }

}