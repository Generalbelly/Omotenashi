<?php

namespace App\Repositories;
use App\Domains\Entities\Entity;
use Log;

trait CommonRepositoryTrait
{
    protected $entity;

    protected $entityClass;

    protected $perPage = 20;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        $this->entityClass = get_class($entity);
    }

    public function all()
    {
        return $this->entityClass::all();
    }

    public function create(array $data)
    {
        return $this->entity::create($data);
    }

    public function update(array $data, $id)
    {
        $entity = $this->findOrFail($id);
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    public function destroy($ids)
    {
        return $this->entityClass::destroy($ids);
    }

    public function delete($id)
    {
        $entity = $this->findOrFail($id);
        $entity->delete();
        return $entity;
    }

    public function find($id)
    {
        return $this->entityClass::find($id);
    }

    public function findOrFail($id)
    {
        return $this->entityClass::findOrFail($id);
    }

    public function selectOne($predicates)
    {
        return $this->entityClass::where(function($query) use ($predicates){
            foreach($predicates as $column => $value){
                $query->where($column, '=', $value);
            }
        })->first();
    }

    public function select($predicates)
    {
        return $this->entityClass::where(function($query) use ($predicates){
            foreach($predicates as $column => $value){
                $query->where($column, '=', $value);
            }
        })->get();
    }

    public function where($column, $operator=null, $value=null)
    {
        return $this->entityClass::where($column, $operator, $value);
    }

    public function whereHas($column, $operator=null, $value=null)
    {
        return $this->entityClass::whereHas($column, $operator, $value);
    }

    public function with($relations)
    {
        return $this->entityClass::with($relations);
    }

    public function paging($predicates=[], $orders=[], $page=0, $search=null, $perPage=null)
    {
        $query = $this->entity->newQuery();
        foreach($predicates as $predicate){
            $query->where($predicate['column'], $predicate['operator'], $predicate['value']);
        }
        if($search){
            $query->where(function($query) use ($search){
                foreach($this->entity->searchColumns as $column){
                    Log::error('column '.$column);
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

    public function batchUpdate(array $dataArray, $parentEntity, string $relationAttribute, string $foreignKey)
    {
        $oldEntities = $parentEntity->getAttribute($relationAttribute)->toArray();
        $newEntities = [];

        foreach ($dataArray as $data) {
            if ($data['id']) {
                $newEntity = $this->update($data, $data['id']);
            } else {
                $newEntity = $this->create(array_merge($data, [
                    $foreignKey => $parentEntity->getAttribute('id'),
                ]));
            }
            $newEntities[] = $newEntity;
        }

        $entityIdsToDelete = array_diff(
            array_column($oldEntities, 'id'),
            array_column($newEntities, 'id')
        );

        if (count($entityIdsToDelete) > 0) {
            $this->destroy($entityIdsToDelete);
        }

        return $newEntities;

    }

}