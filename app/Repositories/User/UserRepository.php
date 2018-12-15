<?php

namespace App\Repositories\User;

use App\Domains\Entities\UserEntity;

use Auth0\Login\Auth0User;
use App\Domains\Models\Auth0JWTUser;
use Auth0\Login\Repository\Auth0UserRepository;
use App\Repositories\CommonRepositoryTrait;

class UserRepository extends Auth0UserRepository implements UserRepositoryContract
{
    use CommonRepositoryTrait;

    protected $entity;

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
        $user = UserEntity::where('sub', $profile['sub'])->first();

        // In not, add them to the database
        if (!$user) {
            $user = new UserEntity();

            // All are required, no default set
            $user->setAttribute('email', $profile['email']);
            $user->setAttribute('sub', $profile['sub']);
            $user->setAttribute('name', isset( $profile['name'] ) ? $profile['name'] : '');

            $user->save();
        }
        return $user;
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
        $user = $this->upsertUser((array)$jwt);
        return new Auth0JWTUser($user->getAttributes());
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
        $user = $this->upsertUser($userinfo['profile']);
        return new Auth0User(
            $user->getAttributes(),
            $userinfo['accessToken']
        );
    }

}