<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Mitra;
use App\Traits\Response;

class MitraDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Mitra::all();
            return $this->sendResponse(true, $response, 'get all mitra data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all mitra data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Mitra::paginate(10);
            return $this->sendResponse(true, $response, 'get all mitra data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all mitra data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Mitra::find($id);
            return $this->sendResponse(true, $response, 'get all mitra data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all mitra data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Mitra::create($data);
            return $this->sendResponse(true, $response, 'insert new mitra success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new mitra failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Mitra::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update mitra success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update mitra failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Mitra::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete mitra success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete mitra failed');
        }
    }
}
