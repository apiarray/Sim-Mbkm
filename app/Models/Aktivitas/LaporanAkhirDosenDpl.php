<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaporanAkhirDosenDpl extends Model
{
    use HasFactory;

    protected $table = 'laporan_akhir_dosen_dpl';
    protected $fillable = [
        'id_laporan_akhir_dosen_dpl',
        'dosen_dpl_id',
        'tahun_ajaran_id',
        'tanggal_laporan_akhir',
    ];

    public static function listLaporanAkhirDosenDpl($is_datatable = 0)
    {
        $result = self::select(
            'laporan_akhir_dosen_dpl.*', 'dosen_dpl.nama as nama_dosen', 'tahun_ajaran.tahun_ajaran', 'semester.nama as semester',
            DB::raw('(SELECT SUM(beban_jam_log_harian) from laporan_akhir_dosen_dpl_detail as b where b.laporan_akhir_dosen_dpl_id = laporan_akhir_dosen_dpl.id) as jumlah_beban_harian'),
            DB::raw('(SELECT SUM(beban_jam_log_mingguan) from laporan_akhir_dosen_dpl_detail as b where b.laporan_akhir_dosen_dpl_id = laporan_akhir_dosen_dpl.id) as jumlah_beban_mingguan'),
            DB::raw('(SELECT SUM(beban_jam_laporan_akhir) from laporan_akhir_dosen_dpl_detail as b where b.laporan_akhir_dosen_dpl_id = laporan_akhir_dosen_dpl.id) as jumlah_beban_laporan_akhir'),
            
        )
        ->leftJoin('dosen_dpl', 'dosen_dpl.id', 'laporan_akhir_dosen_dpl.dosen_dpl_id')
        ->leftJoin('tahun_ajaran', 'tahun_ajaran.id', 'laporan_akhir_dosen_dpl.tahun_ajaran_id')
        ->leftjoin('semester','semester.id','=','tahun_ajaran.semester_id');
        if (!($is_datatable == 1 || $is_datatable == true)) {
            $result = $result->get();
        }

        return $result;
    }
}
