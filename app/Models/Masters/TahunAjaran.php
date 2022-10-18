<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TahunAjaran extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_TIDAK_AKTIF = 'tidak_aktif';

    protected $table = 'tahun_ajaran';
    protected $fillable = [
        'semester_id',
        'tahun_ajaran',
        'status'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public static function getListTahunAjaran()
    {
        $result = self::select('tahun_ajaran.id', 'tahun_ajaran.tahun_ajaran', 'tahun_ajaran.status', 'semester.nama as semester')
                        ->join('semester', 'semester.id', 'tahun_ajaran.semester_id')
                        ->orderBy('tahun_ajaran.tahun_ajaran', 'ASC')
                        ->orderBy('tahun_ajaran.semester_id', 'ASC')
                        ->get();

        return $result;
    }
}
