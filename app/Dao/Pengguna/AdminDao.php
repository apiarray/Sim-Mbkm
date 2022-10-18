<?php

namespace App\Dao\Pengguna;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = User::simplePaginate(10);
            return $this->sendResponse(true, $response, 'get all admin data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all admin data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = User::paginate(10);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = User::find($id);
            return $this->sendResponse(true, $response, 'get all dosen data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all dosen data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            if(!isset($data['password']) || (empty($data['password']))){
                $data['password'] = Hash::make($data['email']);
            }
            $response = User::create($data);
            return $this->sendResponse(true, $response, 'insert new admin success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new admin failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = User::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update admin success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update admin failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = User::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete admin success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete admin failed');
        }
    }
}
