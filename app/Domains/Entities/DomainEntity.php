<?php

namespace App\Domains\Entities;

class DomainEntity extends Entity
{
    protected $table = 'domains';
    protected $fillable = [
        'protocol',
        'domain',
        'project_id',
    ];
    public $searchColumns = [
        'protocol',
        'domain',
    ];

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }
}
