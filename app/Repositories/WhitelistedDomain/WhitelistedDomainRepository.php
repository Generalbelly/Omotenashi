<?php

namespace App\Repositories\WhitelistedDomain;

use App\Domains\Entities\WhitelistedDomainEntity;
use App\Repositories\BaseRepository;

class WhitelistedDomainRepository extends BaseRepository implements WhitelistedDomainRepositoryContract
{
    /**
     * WhitelistedDomainRepository constructor.
     * @param WhitelistedDomainEntity $whitelistedDomainEntity
     */
    public function __construct(WhitelistedDomainEntity $whitelistedDomainEntity)
    {
        parent::__construct($whitelistedDomainEntity);
    }
}