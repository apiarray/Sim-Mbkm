<?php

namespace App\Dao\Pengguna;

use App\Dao\BaseDao;
use App\Traits\Response;

use App\Models\RegistrasiMahasiswa;

class RegistrasiDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Registrasi::simplePaginate(10);
            return $this->sendResponse(true, $response, 'get all Registrasi data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all Registrasi data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Registrasi::paginate(10);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Registrasi::find($id);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Registrasi::create($data);
            return $this->sendResponse(true, $response, 'insert new Registrasi success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new Registrasi failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Registrasi::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update Registrasi success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update Registrasi failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Registrasi::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete Registrasi success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete Registrasi failed');
        }
    }
}
