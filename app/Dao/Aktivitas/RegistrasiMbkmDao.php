<?php

namespace App\Dao\Aktivitas;

use App\Dao\BaseDao;
use App\Models\Aktivitas\RegistrasiMbkm;
use App\Traits\Response;

use Illuminate\Support\Collection;

class RegistrasiMbkmDao implements BaseDao
{
    use Response;

    public function getAll(): object
    {
        try {
            $response = RegistrasiMbkm::get();
            return $this->sendResponse(true, $response, 'get all registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all registrasi mbkm failed');
        }
    }

    public function getPaginate(): object
    {
        try {
            $response = RegistrasiMbkm::select(
                'registrasi_mbkm.*',
                'mahasiswa.nama as nama_mahasiswa',
                'mahasiswa.nim as nim_mahasiswa',
                'mahasiswa.status as status_mahasiswa',
                'dosen_dpl.nip as nip_dosen_dpl',
                'dosen_dpl.nama as nama_dosen_dpl',
                'kelas.nama as kelas',
                'jurusan.nama as jurusan',
                'fakultas.nama as fakultas',
                'program.nama as program',
                'tahun_ajaran.tahun_ajaran',
                'semester.nama as semester'
            )
                ->join('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
                ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
                ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
                ->leftJoin('fakultas', 'fakultas.id', 'jurusan.fakultas_id')
                ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
                ->join('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id')
                ->join('semester', 'semester.id', 'tahun_ajaran.semester_id')
                ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
                ->orderBy('registrasi_mbkm.created_at', 'desc');

            if (auth()->guard('mahasiswa')->check()) {
                $response->where('registrasi_mbkm.mahasiswa_id', '=', auth()->guard('mahasiswa')->user()->id);
            }

            if (auth()->guard('dosen')->check()) {
                $response->where('registrasi_mbkm.dosen_dpl_id', '=', auth()->guard('dosen')->user()->id);
                $response->where('registrasi_mbkm.status_validasi', '=', 'tervalidasi');
            }

            $response = $response->paginate(10);


            return $this->sendResponse(true, $response, 'get all registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get all registrasi mbkm failed');
        }
    }

    public function getById(int $id): object
    {
        try {
            $response = RegistrasiMbkm::with(
                'mahasiswa:id,nama,nim',
                'kelas:id,jurusan_id,nama',
                'kelas.jurusan:id,fakultas_id,kode,nama',
                'kelas.jurusan.fakultas:id,nama',
                'dosenDpl:id,nama,nip',
                'program:id,nama',
                'tahunAjaran:id,tahun_ajaran,semester_id',
                'tahunAjaran.semester:id,nama'
            )->find($id);
            return $this->sendResponse(true, $response, 'get registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'get registrasi mbkm failed');
        }
    }

    public function insert(array $data): object
    {
        try {
            $response = RegistrasiMbkm::create($data);
            return $this->sendResponse(true, $response, 'insert new registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'insert new registrasi mbkm failed');
        }
    }

    public function update(int $id, array $data): object
    {
        try {
            $response = RegistrasiMbkm::where('id', $id)->update($data);
            return $this->sendResponse(true, $response, 'update registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'update registrasi mbkm failed');
        }
    }

    public function delete(int $id): object
    {
        try {
            $response = RegistrasiMbkm::where('id', $id)->delete();
            return $this->sendResponse(true, $response, 'delete registrasi mbkm success');
        } catch (\Throwable $th) {
            return $this->sendResponse(false, $th->getMessage(), 'delete registrasi mbkm failed');
        }
    }
}
