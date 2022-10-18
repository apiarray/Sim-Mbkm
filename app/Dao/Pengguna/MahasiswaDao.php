<?php

namespace App\Dao\Pengguna;

use App\Dao\BaseDao;
use App\Traits\Response;

use App\Models\Pengguna\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class MahasiswaDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Mahasiswa::simplePaginate(10);
            return $this->sendResponse(true, $response, 'get all mahasiswa data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all mahasiswa data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Mahasiswa::select('mahasiswa.*')->with('registrasi_mbkm', 'registrasi_mbkm_aktif', 'registrasi_mbkm_terakhir')->paginate(10);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Mahasiswa::find($id);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            if(empty(($data['password']))){
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
            $response = Mahasiswa::create($data);
            return $this->sendResponse(true, $response, 'insert new mahasiswa success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new mahasiswa failed');
        }
    }

    public function update(int $id, array $data): object
    {
        if(empty(($data['password']))){
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        try {
            $response = Mahasiswa::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update mahasiswa success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update mahasiswa failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Mahasiswa::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete mahasiswa success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete mahasiswa failed');
        }
    }
}
