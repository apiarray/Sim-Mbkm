<?php

namespace App\Dao\Identitas;

use App\Dao\BaseDao;
use App\Traits\Response;

use App\Models\IdentitasUniversitas;

class IdentitasUniversitasDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $data = IdentitasUniversitas::all();
            return $this->sendResponse(true, $data, 'get all data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $data = IdentitasUniversitas::paginate(10);
            return $this->sendResponse(true, $data, 'get all data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $data = IdentitasUniversitas::find($id);
            return $this->sendResponse(true, $data, 'get item success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get item failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = IdentitasUniversitas::create($data);
            return $this->sendResponse(true, $response, 'insert new property success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new property failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = IdentitasUniversitas::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update properti success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update properti failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = IdentitasUniversitas::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete identitas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete identitas failed');
        }
    }
}
