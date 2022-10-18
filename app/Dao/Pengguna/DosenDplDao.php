<?php

namespace App\Dao\Pengguna;

use App\Dao\BaseDao;
use App\Models\Pengguna\DosenDpl;
use App\Traits\Response;
use Illuminate\Support\Facades\Hash;

class DosenDplDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = DosenDpl::simplePaginate(10);
            return $this->sendResponse(true, $response, 'get dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get dosen data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = DosenDpl::paginate(10);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = DosenDpl::find($id);
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
            $response = DosenDpl::insert($data);
            return $this->sendResponse(true, $response, 'insert dosen success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get dosen data failed');
        }
    }

    public function update(int $id, array $data): object
    {
        if(empty(($data['password']))){
            unset($data['password']);
        }
        try {
            $response = DosenDpl::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update dosen success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update dosen failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = DosenDpl::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete dosen success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete dosen failed');
        }
    }
}
