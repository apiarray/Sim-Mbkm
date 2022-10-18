<?php

namespace App\Dao;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\KotaKabupaten;

class KotaKabupatenDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = KotaKabupaten::get();
            return $this->sendResponse(true, $response, 'get all kota/kabupaten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kota/kabupaten data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = KotaKabupaten::paginate(10);
            return $this->sendResponse(true, $response, 'get all kota/kabupaten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kota/kabupaten data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = KotaKabupaten::find($id);
            return $this->sendResponse(true, $response, 'get all kota/kabupaten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kota/kabupaten data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = KotaKabupaten::create($data);
            return $this->sendResponse(true, $response, 'insert new kota/kabupaten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new kota/kabupaten failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = KotaKabupaten::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update kota/kabupaten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update kota/kabupaten failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = KotaKabupaten::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete kota/kabupaten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete kota/kabupaten failed');
        }
    }
}
