<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class LogbookMingguan extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_TERVALIDASI = 'tervalidasi';
    public const STATUS_MENGAJUKAN = 'mengajukan';
    public const STATUS_REVISI = 'revisi';

    protected $table = 'logbook_mingguan';
    protected $fillable = [
        'id_log_mingguan',
        'tanggal',
        'mahasiswa_id',
        'dosen_dpl_id',
        'program_id',
        'tahun_ajaran_id',
        'link_dokumen',
        'link_video',
        'link_youtube',
        'judul',
        'deskripsi',
        'status'
    ];

    public static function listLogbookMingguan($is_datatable = 0)
    {
        $result = self::select(
            'logbook_mingguan.*',
            DB::raw("DATE_FORMAT(logbook_mingguan.tanggal,'%d-%m-%Y') AS ttanggal"),
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
            'tahun_ajaran.tahun_ajaran'
        )
            ->leftJoin('registrasi_mbkm', 'registrasi_mbkm.id', 'logbook_mingguan.registrasi_mbkm_id')
            ->leftJoin('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
            ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
            ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
            ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
            ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
            ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id')
            ->where('registrasi_mbkm.status_validasi', '=', 'tervalidasi');

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
