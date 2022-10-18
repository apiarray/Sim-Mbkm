<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PenilaianDosenDpl extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_TERVALIDASI = 'tervalidasi';
    public const STATUS_MENGAJUKAN = 'mengajukan';
    public const STATUS_REVISI = 'revisi';

    protected $table = 'penilaian_dosen_dpl';
    protected $fillable = [
        'id_penilaian',
        'registrasi_mbkm_id',
        'tanggal_penilaian',
        'nilai_raw',
        'nilai',
        'status',
    ];

    public static function listPenilaianDosenDpl($is_datatable = 0)
    {
        $result = self::select(
            'penilaian_dosen_dpl.*',
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
            DB::raw("(SELECT COUNT(*) from logbook_mingguan where logbook_mingguan.registrasi_mbkm_id = penilaian_dosen_dpl.registrasi_mbkm_id) as count_logbook_mingguan_all"),
            DB::raw("(SELECT COUNT(*) from logbook_mingguan 
                            where logbook_mingguan.registrasi_mbkm_id = penilaian_dosen_dpl.registrasi_mbkm_id 
                            and logbook_mingguan.status = 'tervalidasi') as count_logbook_mingguan_valid"),
            DB::raw("(SELECT COUNT(*) from laporan_akhir_mahasiswa where laporan_akhir_mahasiswa.registrasi_mbkm_id = penilaian_dosen_dpl.registrasi_mbkm_id) as count_laporan_akhir_mahasiswa_all"),
            DB::raw("(SELECT COUNT(*) from laporan_akhir_mahasiswa 
                            where laporan_akhir_mahasiswa.registrasi_mbkm_id = penilaian_dosen_dpl.registrasi_mbkm_id 
                            and laporan_akhir_mahasiswa.status_laporan_akhir = 'validasi') as count_laporan_akhir_mahasiswa_valid"),
        )
            ->leftJoin('registrasi_mbkm', 'registrasi_mbkm.id', 'penilaian_dosen_dpl.registrasi_mbkm_id')
            ->leftJoin('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
            ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
            ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
            ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
            ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id');

        if (!($is_datatable == 1 || $is_datatable == true)) {
            $result = $result->get();
        }

        return $result;
    }
}
