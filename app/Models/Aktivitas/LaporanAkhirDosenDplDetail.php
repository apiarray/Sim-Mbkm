<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhirDosenDplDetail extends Model
{
    use HasFactory;

    protected $table = 'laporan_akhir_dosen_dpl_detail';
    protected $fillable = [
        'laporan_akhir_dosen_dpl_id',
        'registrasi_mbkm_id',
        'beban_jam_log_harian',
        'beban_jam_log_mingguan',
        'beban_jam_laporan_akhir',
    ];
}
