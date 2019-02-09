<?php

namespace App\Repositories\OAuth;

use App\Domains\Entities\OAuthEntity;
use App\Repositories\BaseRepository;

class OAuthRepository extends BaseRepository implements OAuthRepositoryContract
{
    /**
     * OAuthRepository constructor.
     * @param OAuthEntity $oauthEntity
     */
    public function __construct(OAuthEntity $oauthEntity)
    {
        parent::__construct($oauthEntity);
    }
}