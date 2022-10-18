<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Jenjang;
use App\Traits\Response;

class JenjangDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Jenjang::all();
            return $this->sendResponse(true, $response, 'get all jenjang success');
        } catch (\Throwable $th) {
            return $th->getMessage(false, $th->getMessage(), 'get all jenjang failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Jenjang::paginate(10);
            return $this->sendResponse(true, $response, 'get all jenjang success');
        } catch (\Throwable $th) {
            return $th->getMessage(false, $th->getMessage(), 'get all jenjang failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Jenjang::find($id);
            return $this->sendResponse(true, $response, 'get jenjang success');
        } catch (\Throwable $th) {
            return $th->getMessage(false, $th->getMessage(), 'get jenjang failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Jenjang::insert($data);
            return $this->sendResponse(true, $response, 'insert new jenjang success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new jenjang failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Jenjang::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update jenjang success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'updaet jenjang failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Jenjang::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete jenjang success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete jenjang failed');
        }
    }
}
