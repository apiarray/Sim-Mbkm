<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhirMahasiswaDetail extends Model
{
    use HasFactory;

    public const STATUS_TERVALIDASI = 'tervalidasi';
    public const STATUS_MENGAJUKAN = 'mengajukan';
    public const STATUS_REVISI = 'revisi';

    protected $table = 'laporan_akhir_mahasiswa_detail';
    protected $fillable = [
        'id_log_book_mingguan',
        'laporan_akhir_mahasiswa_id'
    ];

    public static function listLogbookmahasiswa($is_datatable = 0)
    {
        $result = self::select(
            'laporan_akhir_mahasiswa_detail.*', 'registrasi_mbkm.id_registrasi', 'registrasi_mbkm.mahasiswa_id', 'registrasi_mbkm.program_id', 'registrasi_mbkm.tahun_ajaran_id', 'registrasi_mbkm.kelas_id', 'registrasi_mbkm.dosen_dpl_id', 'mahasiswa.nim', 'mahasiswa.nama as mahasiswa_nama', 'kelas.nama as kelas_nama', 'kelas.jurusan_id', 'jurusan.nama as jurusan_nama', 'dosen_dpl.nama as dosen_dpl_nama', 'program.nama as program_nama', 'tahun_ajaran.tahun_ajaran' ,'laporan_akhir_mahasiswa.id as id_laporan_akhir_mahasiswa','laporan_akhir_mahasiswa.deskripsi','semester.nama as semester', 'laporan_akhir_mahasiswa.id as id_laporan_akhir_mahasiswa', 'laporan_akhir_mahasiswa.registrasi_mbkm_id','logbook_mingguan.status', 'laporan_akhir_mahasiswa.status_laporan_akhir'
        )
        ->leftJoin('laporan_akhir_mahasiswa', 'laporan_akhir_mahasiswa.id', 'laporan_akhir_mahasiswa_detail.laporan_akhir_mahasiswa_id')
        ->leftJoin('registrasi_mbkm', 'registrasi_mbkm.id', 'laporan_akhir_mahasiswa.registrasi_mbkm_id')
        ->leftJoin('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
        ->leftJoin('kelas', 'kelas.id', 'registrasi_mbkm.kelas_id')
        ->leftJoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
        ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'registrasi_mbkm.dosen_dpl_id')
        ->leftJoin('program', 'program.id', 'registrasi_mbkm.program_id')
        ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'registrasi_mbkm.tahun_ajaran_id')
        ->leftjoin('semester','semester.id','=','tahun_ajaran.semester_id')
        ->leftjoin('logbook_mingguan','logbook_mingguan.id','=','laporan_akhir_mahasiswa_detail.id_log_book_mingguan');
        if (!($is_datatable == 1 || $is_datatable == true)) {
            $result = $result->get();
        }

        return $result;
    }

    public function registrasiMbkm()
    {
        return $this->belongsTo(RegistrasiMbkm::class);
    }

    
}
