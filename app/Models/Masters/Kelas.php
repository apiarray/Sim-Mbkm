<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';
    protected $fillable = [
        'nama',
        'jurusan_id'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }


    public static function getListKelas()
    {
        $result = self::select('kelas.id', 'kelas.nama', 'jurusan.nama as jurusan')
            ->leftjoin('jurusan', 'jurusan.id', 'kelas.jurusan_id')
            ->orderby('kelas.nama', 'ASC')
            ->get();

        return $result;
    }
}
