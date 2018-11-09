<?php

namespace App\Repositories\Site;

use App\Domains\Entities\SiteEntity;
use App\Repositories\BaseRepository;

class SiteRepository extends BaseRepository implements SiteRepositoryContract
{
    /**
     * SiteRepository constructor.
     * @param SiteEntity $siteEntity
     */
    public function __construct(SiteEntity $siteEntity)
    {
        parent::__construct($siteEntity);
    }
}