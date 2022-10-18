<?php
namespace App\Dao;

interface BaseDao {
    public function getAll(): object;
    public function getPaginate(): object;
    public function getById(int $id): object;
    public function insert(array $data): object;
    public function update(int $id, array $data): object;
    public function delete(int $id): object;
}