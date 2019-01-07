<?php

namespace App\Domains\Entities;

class WhitelistedDomainEntity extends Entity
{
    protected $table = 'whitelisted_domains';
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
        return $this->belongsTo(
            'App\Domains\Entities\ProjectEntity',
            'project_id',
            'id'
        );
    }
}
