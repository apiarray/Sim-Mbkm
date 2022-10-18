<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Jurusan;
use App\Traits\Response;

class JurusanDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Jurusan::with('fakultas', 'fakultas.jenjang')->get();
            return $this->sendResponse(true, $response, 'get data jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get data jurusan failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Jurusan::with('fakultas', 'fakultas.jenjang')->paginate(10);
            return $this->sendResponse(true, $response, 'get data jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get data jurusan failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Jurusan::with('fakultas', 'fakultas.jenjang')->find($id);
            return $this->sendResponse(true, $response, 'get data jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get data jurusan failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Jurusan::create($data);
            return $this->sendResponse(true, $response, 'insert new jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new jurusan failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Jurusan::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update jurusan failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Jurusan::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete jurusan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete jurusan failed');
        }
    }
}
