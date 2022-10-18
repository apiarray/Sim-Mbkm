<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Kelas;
use App\Traits\Response;

class KelasDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Kelas::with('jurusan', 'jurusan.fakultas', 'jurusan.fakultas', 'jurusan.fakultas.jenjang')
                ->get();
            return $this->sendResponse(true, $response, 'get all kelas data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kelas data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Kelas::with('jurusan', 'jurusan.fakultas', 'jurusan.fakultas', 'jurusan.fakultas.jenjang')->paginate(10);
            return $this->sendResponse(true, $response, 'get all kelas data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kelas data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Kelas::with('jurusan', 'jurusan.fakultas', 'jurusan.fakultas', 'jurusan.fakultas.jenjang')->find($id);
            return $this->sendResponse(true, $response, 'get all kelas data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all kelas data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Kelas::create($data);
            return $this->sendResponse(true, $response, 'insert new kelas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new kelas failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Kelas::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update kelas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update kelas failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Kelas::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete kelas success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete kelas failed');
        }
    }
}
