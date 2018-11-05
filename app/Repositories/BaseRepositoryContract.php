<?php

namespace App\Repositories;

interface BaseRepositoryContract {

    public function all();

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getEntity();

    public function setEntity($entity);

    public function with($relations);

    public function find($id);

    public function selectOne($predicates);

    public function select($predicates);

    public function paging($predicates=[], $orders=[], $page=0, $search=null, $perPage=null);

}