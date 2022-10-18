<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Models\Masters\Penilaian;
use App\Traits\Response;
use Illuminate\Support\Facades\DB;

class PenilaianDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = Penilaian::all();
            return $this->sendResponse(true, $response, 'get all penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all penilaian data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = Penilaian::select('penilaian.*', 'bab_penilaian.nama_bab', DB::raw("(SELECT count(*) from pilihan_penilaian where pilihan_penilaian.penilaian_id = penilaian.id) as jumlah_pilihan"))
                        ->join('bab_penilaian', 'penilaian.bab_penilaian_id', 'bab_penilaian.id')
                        ->paginate(10);
            return $this->sendResponse(true, $response, 'get all penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all penilaian data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = Penilaian::find($id);
            return $this->sendResponse(true, $response, 'get all penilaian data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all penilaian data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = Penilaian::create($data);
            return $this->sendResponse(true, $response, 'insert new penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new penilaian failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = Penilaian::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update penilaian failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = Penilaian::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete penilaian success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete penilaian failed');
        }
    }
}
