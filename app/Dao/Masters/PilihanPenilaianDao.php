<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\PilihanPenilaian;
use App\Traits\Response;

class PilihanPenilaianDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = PilihanPenilaian::all();
            return $this->sendResponse(true, $response, 'get all pilihan penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all pilihan penilaian data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = PilihanPenilaian::paginate(10);
            return $this->sendResponse(true, $response, 'get all pilihan penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all pilihan penilaian data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = PilihanPenilaian::find($id);
            return $this->sendResponse(true, $response, 'get pilihan penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get pilihan penilaian data failed');
        }
    }
    
    public function getByParentId(int $id, string $column): object
    {
        try {
            $response = PilihanPenilaian::where($column, $id)->get();
            return $this->sendResponse(true, $response, 'get pilihan penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get pilihan penilaian data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = PilihanPenilaian::create($data);
            return $this->sendResponse(true, $response, 'insert new pilihan penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new pilihan penilaian failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = PilihanPenilaian::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update pilihan penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update pilihan penilaian failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = PilihanPenilaian::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete pilihan penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete pilihan penilaian failed');
        }
    }
}
