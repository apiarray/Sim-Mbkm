<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Fakultas;
use App\Traits\Response;

use Illuminate\Support\Collection;

class FakultasDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Fakultas::with('jenjang')->get();
            return $this->sendResponse(true, $response, 'get all fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all fakultas failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Fakultas::with('jenjang')->paginate(10);
            return $this->sendResponse(true, $response, 'get all fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all fakultas failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Fakultas::with('jenjang')->find($id);
            return $this->sendResponse(true, $response, 'get fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get fakultas failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Fakultas::create($data);
            return $this->sendResponse(true, $response, 'insert new fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new fakultas failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Fakultas::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update fakultas failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Fakultas::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete fakultas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete fakultas failed');
        }
    }
}
