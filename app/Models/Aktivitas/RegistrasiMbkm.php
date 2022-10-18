<?php

namespace App\Models\Aktivitas;

use App\Models\Masters\Kelas;
use App\Models\Masters\Program;
use App\Models\Masters\TahunAjaran;
use App\Models\Pengguna\DosenDpl;
use App\Models\Pengguna\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegistrasiMbkm extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_MENGAJUKAN = 'mengajukan';
    public const STATUS_TERVALIDASI = 'tervalidasi';
    public const STATUS_BATAL = 'batal';

    protected $table = 'registrasi_mbkm';
    protected $fillable = [
        'id_registrasi',
        'mahasiswa_id',
        'kelas_id',
        'program_id',
        'kelas_id',
        'tahun_ajaran_id',
        'dosen_dpl_id',
        'tanggal_registrasi',
        'tanggal_validasi',
        'status_validasi',
        'lampiran'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function dosenDpl()
    {
        return $this->belongsTo(DosenDpl::class, 'dosen_dpl_id', 'id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }

    public static function listRegistrasi($is_datatable = 0)
    {
        $result = self::select('registrasi_mbkm.*', 'mahasiswa.nama as nama_mahasiswa', 'mahasiswa.nim as nim_mahasiswa', 'mahasiswa.status as status_mahasiswa',
                'dosen_dpl.nip as nip_dosen_dpl', 'dosen_dpl.nama as nama_dosen_dpl', 'kelas.nama as kelas', 'jurusan.nama as jurusan', 'fakultas.nama as fakultas',
                'program.nama as program', 'tahun_ajaran.tahun_ajaran', 'semester.nama as semester')
        ->join('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
        ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
        ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
        ->leftJoin('fakultas', 'fakultas.id', 'jurusan.fakultas_id')
        ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
        ->join('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id')
        ->join('semester', 'semester.id', 'tahun_ajaran.semester_id')
        ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
        ->orderBy('registrasi_mbkm.created_at', 'desc');
        if (!($is_datatable == 1 || $is_datatable == true)) {
            $result = $result->get();
        }

        return $result;
    }
}
