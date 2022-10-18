<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\BabPenilaian;
use App\Traits\Response;

class BabPenilaianDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = BabPenilaian::all();
            return $this->sendResponse(true, $response, 'get all bab penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all bab penilaian data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = BabPenilaian::paginate(10);
            return $this->sendResponse(true, $response, 'get all bab penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all bab penilaian data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = BabPenilaian::find($id);
            return $this->sendResponse(true, $response, 'get all bab penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all bab penilaian data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = BabPenilaian::create($data);
            return $this->sendResponse(true, $response, 'insert new bab penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new bab penilaian failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = BabPenilaian::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update bab penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update bab penilaian failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = BabPenilaian::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete bab penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete bab penilaian failed');
        }
    }
}
