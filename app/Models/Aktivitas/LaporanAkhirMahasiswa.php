<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhirMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'laporan_akhir_mahasiswa';
    protected $fillable = [
        'registrasi_mbkm_id',
        'deskripsi',
        'materi_pdf',
        'link_video',
        'link_youtube',
        'judul_materi',
        'tanggal_laporan_akhir',
        'status_laporan_akhir'
    ];

    public static function listLaporanAkhirMahasiswa($is_datatable)
    {
        $result = self::select(
            'laporan_akhir_mahasiswa.*',
            'registrasi_mbkm.id_registrasi',
            'registrasi_mbkm.mahasiswa_id',
            'registrasi_mbkm.program_id',
            'registrasi_mbkm.tahun_ajaran_id',
            'registrasi_mbkm.kelas_id',
            'registrasi_mbkm.dosen_dpl_id',
            'mahasiswa.nim',
            'mahasiswa.nama as mahasiswa_nama',
            'kelas.nama as kelas_nama',
            'kelas.jurusan_id',
            'jurusan.nama as jurusan_nama',
            'dosen_dpl.nama as dosen_dpl_nama',
            'program.nama as program_nama',
            'tahun_ajaran.tahun_ajaran',
            'semester.nama as semester',
            'laporan_akhir_mahasiswa.status_laporan_akhir'
        )
            ->leftJoin('registrasi_mbkm', 'registrasi_mbkm.id', 'laporan_akhir_mahasiswa.registrasi_mbkm_id')
            ->leftJoin('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
            ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
            ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
            ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
            ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id')
            ->leftjoin('semester', 'semester.id', '=', 'tahun_ajaran.semester_id');

        if (auth()->guard('mahasiswa')->check()) {
            $result->where('registrasi_mbkm.mahasiswa_id', auth()->guard('mahasiswa')->user()->id);
        }

        if (auth()->guard('dosen')->check()) {
            $result->where('registrasi_mbkm.dosen_dpl_id', auth()->guard('dosen')->user()->id);
        }

        if (!($is_datatable == 1 || $is_datatable == true)) {
            $result = $result->get();
        }

        return $result;
    }
}
