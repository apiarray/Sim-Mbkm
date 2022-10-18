<?php

namespace App\Dao\Aktivitas;

use App\Dao\BaseDao;
use App\Models\Aktivitas\LogbookHarian;
use App\Traits\Response;

use Illuminate\Support\Collection;

class LogbookHarianDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = LogbookHarian::with('jenjang')->get();
            return $this->sendResponse(true, $response, 'get all logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all logbook harian failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = LogbookHarian::with('jenjang')->paginate(10);
            return $this->sendResponse(true, $response, 'get all logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all logbook harian failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = LogbookHarian::with('jenjang')->find($id);
            return $this->sendResponse(true, $response, 'get logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get logbook harian failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = LogbookHarian::create($data);
            return $this->sendResponse(true, $response, 'insert new logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new logbook harian failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = LogbookHarian::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update logbook harian failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = LogbookHarian::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete logbook harian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete logbook harian failed');
        }
    }
}
