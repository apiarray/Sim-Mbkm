<?php

namespace App\Dao;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\Masters\Kontenlanding;


class KontenlandingDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Kontenlanding::get();
            return $this->sendResponse(true, $response, 'get all jenis konten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all jenis konten data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Kontenlanding::paginate(10);
            return $this->sendResponse(true, $response, 'get all jenis konten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all jenis konten data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Kontenlanding::find($id);
            return $this->sendResponse(true, $response, 'get all jenis konten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all jenis konten data failed');
        }
    }
	
	 public function getJenis(int $id): object
    {
        try {
            $response = Kontenlanding::find($id);
            return $this->sendResponse(true, $response, 'get all jenis konten data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all jenis konten data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Kontenlanding::create($data);
            return $this->sendResponse(true, $response, 'insert new konten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new konten failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Kontenlanding::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update jenis konten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update jenis konten failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Kontenlanding::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete jenis konten success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete jenis konten failed');
        }
    }
}
