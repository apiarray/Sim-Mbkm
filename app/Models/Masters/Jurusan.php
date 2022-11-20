<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jurusan';
    protected $fillable = [
        'nama',
        'kode',
        'fakultas_id'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'id');
    }

    public static function getListJurusan()
    {
        $result = self::select('jurusan.id', 'jurusan.nama', 'jurusan.kode', 'fakultas.nama as fakultas')
            ->leftjoin('fakultas', 'fakultas.id', 'jurusan.fakultas_id')
            // ->leftjoin('kelas', 'kelas.jurusan_id', 'jurusan.id')
            ->orderby('fakultas.nama', 'ASC')
            ->get();

        return $result;
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id', 'jurusan_id');
    }
}
