<?php

namespace App\Repositories\User;

use App\Domains\Entities\UserEntity;

use Auth0\Login\Auth0User;
use App\Domains\Models\Auth0JWTUser;
use Auth0\Login\Repository\Auth0UserRepository;

class UserRepository extends Auth0UserRepository implements UserRepositoryContract
{
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

    public function all()
    {
        return $this->entity->all();
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->entity->destroy($id);
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

    public function with($relations)
    {
        return $this->entity->with($relations);
    }

    public function find($id)
    {
        return $this->entity-findOrFail($id);
    }

    public function selectOne($predicates)
    {
        return $this->entity->where(function($query) use ($predicates){
            foreach($predicates as $column => $value){
                $query->where($column, '=', $value);
            }
        })->first();
    }

    public function select($predicates)
    {
        return $this->entity->where(function($query) use ($predicates){
            foreach($predicates as $column => $value){
                $query->where($column, '=', $value);
            }
        })->get();
    }

    public function paging($predicates=[], $orders=[], $page=0, $search=null, $perPage=null)
    {
        $query = $this->entity->newQuery();
        foreach($predicates as $predicate){
            $query->where($predicate['column'], $predicate['operator'], $predicate['value']);
        }
        if($search){
            $query->where(function($query) use ($search){
                foreach($this->searchColumns as $column){
                    $query->orWhere($column, 'like', "%$search%");
                }
            });
        }
        foreach($orders as $order){
            $query->orderBy($order['column'], $order['direction']);
        }
        $total = $query->count('id');
        $perPage = $perPage ? $perPage : $this->perPage;
        $pages = ceil($total/$perPage);
        // 1 2 3 4 5 [6] 7 8 9 10
        $start = $page - 6;
        $end = $page + 4;
        if($start < 0){
            $start = 1;
            $end = 10;
        }else if($pages > $end){
            $start = $pages - 10;
            $end = $pages;
        }
        $query->offset($page*$perPage);
        $query->limit($perPage);
        $entities = $query->get();

        return [
            'total'  => $total,
            'start'  => $start,
            'end'    => $end,
            'entities' => $entities,
        ];
    }

}