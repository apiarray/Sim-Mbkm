<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\Masters\Program;

class ProgramDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Program::all();
            return $this->sendResponse(true, $response, 'get all program data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all program data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Program::paginate(10);
            return $this->sendResponse(true, $response, 'get all program data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all program data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Program::find($id);
            return $this->sendResponse(true, $response, 'get all program data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all program data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Program::create($data);
            return $this->sendResponse(true, $response, 'insert new program success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new program failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Program::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update program success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update program failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Program::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete program success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete program failed');
        }
    }
}
