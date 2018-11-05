<?php

namespace App\Repositories;

class BaseRepository implements BaseRepositoryContract
{
    protected $entity;

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