<?php

namespace App\Repositories\User;

use App\Domains\Entities\UserEntity;
use Auth0\Login\Auth0User;
use App\Domains\Models\Auth0JWTUser;
use Auth0\Login\Repository\Auth0UserRepository;
use App\Repositories\CommonRepositoryTrait;
use Log;

class UserRepository extends Auth0UserRepository implements UserRepositoryContract
{
    use CommonRepositoryTrait;

    public function __construct(UserEntity $userEntity)
    {
        $this->entity = $userEntity;
        $this->entityClass = get_class($userEntity);
    }

    /**
    * Get an existing user or create a new one
    *
    * @param array $profile - Auth0 profile
    *
    * @return UserEntity
    */
    protected function upsertUser($profile)
    {
        // See if we have a user that matches the Auth0 user_id
        $userEntity = $this->where('sub', $profile['sub'])->first();

        // In not, add them to the database
        if (!$userEntity) {
            // All are required, no default set
            $userEntity = $this->create([
                'email' => $profile['email'],
                'sub' => $profile['sub'],
                'name' => isset( $profile['name'] ) ? $profile['name'] : '',
            ]);
        }
        return $userEntity;
    }

    /**
    * Authenticate a user with a decoded ID Token
    *
    * @param object $jwt
    *
    * @return Auth0JWTUser
    */
    public function getUserByDecodedJWT($jwt)
    {
        $userEntity = $this->upsertUser((array)$jwt);
        return new Auth0JWTUser($userEntity->getAttributes());
    }

    /**
    * Get a User from the database using Auth0 profile information
    *
    * @param array $userinfo
    *
    * @return Auth0User
    */
    public function getUserByUserInfo($userinfo)
    {
        $userEntity = $this->upsertUser($userinfo['profile']);
        return new Auth0User(
            $userEntity->getAttributes(),
            $userinfo['accessToken']
        );
    }

}