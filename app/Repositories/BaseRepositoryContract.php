<?php

namespace App\Repositories;

interface BaseRepositoryContract {

    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function destroy($ids);

    public function find($id);

    public function findOrFail($id);

    public function where($column, $operator = null, $value = null);

    public function whereHas($column, $operator = null, $value = null);

    public function with($relations);

    public function paging($predicates = [], $orders = [], $page = 0, $search = null, $perPage = 20);

    public function batchUpdate(array $dataArray, $parentEntity, string $relationAttribute, string $foreignKey);

}