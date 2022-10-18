<?php

namespace App\Dao\Masters;

use App\Dao\BaseDao;
use App\Traits\Response;
use App\Models\Masters\TahunAjaran;

class TahunAjaranDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = TahunAjaran::all();
            return $this->sendResponse(true, $response, 'get all tahun ajaran data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all tahun ajaran data failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = TahunAjaran::paginate(10);
            return $this->sendResponse(true, $response, 'get all tahun ajaran data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all tahun ajaran data failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = TahunAjaran::find($id);
            return $this->sendResponse(true, $response, 'get all tahun ajaran data success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all tahun ajaran data failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $activeTahun = TahunAjaran::where('status', TahunAjaran::STATUS_AKTIF)->exists();

            if ($activeTahun && $data['status'] === TahunAjaran::STATUS_AKTIF) {
                return $this->sendResponse(false, $activeTahun, "Ada tahun ajaran lain yang masih aktif.");
            }

            $response = TahunAjaran::create($data);
            return $this->sendResponse(true, $response, 'insert new tahun ajaran success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new tahun ajaran failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = TahunAjaran::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update tahun ajaran success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update tahun ajaran failed');
        }
    }

    public function updateStatus(int $id): object
    {
        try {
            // $activeTahun = TahunAjaran::where('id', '!=', $id)
            //     ->where('status', TahunAjaran::STATUS_AKTIF)
            //     ->exists();

            // if ($activeTahun) {
            //     return $this->sendResponse(false, $activeTahun, "Ada tahun ajaran lain yang masih aktif.");
            // }

            TahunAjaran::where('id', '!=', $id)->update(['status' => TahunAjaran::STATUS_TIDAK_AKTIF]);

            $selectedTahun = TahunAjaran::find($id);
            $currentStatus = $selectedTahun->status === TahunAjaran::STATUS_AKTIF
                ? TahunAjaran::STATUS_TIDAK_AKTIF
                : TahunAjaran::STATUS_AKTIF;

            $updateStatus = TahunAjaran::where('id', $id)->update([
                'status' => $currentStatus
            ]);

            return $this->sendResponse(true, $updateStatus, 'update status berhasil');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update status tahun ajaran gagal');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = TahunAjaran::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete tahun ajaran success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete tahun ajaran failed');
        }
    }
}
