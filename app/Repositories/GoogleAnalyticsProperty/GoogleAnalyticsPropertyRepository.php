<?php

namespace App\Repositories\GoogleAnalyticsProperty;

use App\Domains\Entities\GoogleAnalyticsPropertyEntity;
use App\Repositories\BaseRepository;

class GoogleAnalyticsPropertyRepository extends BaseRepository implements GoogleAnalyticsPropertyRepositoryContract
{
    /**
     * GoogleAnalyticsPropertyRepository constructor.
     * @param GoogleAnalyticsPropertyEntity $googleAnalyticsPropertyEntity
     */
    public function __construct(GoogleAnalyticsPropertyEntity $googleAnalyticsPropertyEntity)
    {
        parent::__construct($googleAnalyticsPropertyEntity);
    }
}