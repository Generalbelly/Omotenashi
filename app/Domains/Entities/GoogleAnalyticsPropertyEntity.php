<?php

namespace App\Domains\Entities;

class GoogleAnalyticsPropertyEntity extends Entity
{
    protected $table = 'google_analytics_properties';
    protected $fillable = [
        'account_id',
        'account_name',
        'property_id',
        'property_name',
        'website_url',
        'project_id'
    ];

    public function projectEntity()
    {
        return $this->belongsTo('App\Domains\Entities\ProjectEntity');
    }

}
