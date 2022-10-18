<?php

namespace App\Dao\Aktivitas;

use App\Dao\BaseDao;
use App\Models\Aktivitas\LogbookMingguan;
use App\Traits\Response;

use Illuminate\Support\Collection;

class LogbookMingguanDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = LogbookMingguan::get();
            return $this->sendResponse(true, $response, 'get all logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all logbook mingguan failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = LogbookMingguan::paginate(10);
            return $this->sendResponse(true, $response, 'get all logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all logbook mingguan failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = LogbookMingguan::find($id);
            return $this->sendResponse(true, $response, 'get logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get logbook mingguan failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = LogbookMingguan::create($data);
            return $this->sendResponse(true, $response, 'insert new logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new logbook mingguan failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = LogbookMingguan::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update logbook mingguan failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = LogbookMingguan::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete logbook mingguan success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete logbook mingguan failed');
        }
    }
}
