<?php
namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\Masters\Semester;

class SemesterDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Semester::all();
            return $this->sendResponse(true, $response, 'get all semester data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all semester data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Semester::paginate(10);
            return $this->sendResponse(true, $response, 'get all semester data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all semester data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Semester::find($id);
            return $this->sendResponse(true, $response, 'get all semester data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all semester data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Semester::create($data);
            return $this->sendResponse(true, $response, 'insert new semester success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new semester failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Semester::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update semester success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update semester failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Semester::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete semester success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete semester failed');
        }
    }
}