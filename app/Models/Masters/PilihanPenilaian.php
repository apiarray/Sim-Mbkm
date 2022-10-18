<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PilihanPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pilihan_penilaian';
    protected $fillable = [
        'penilaian_id',
        'urutan',
        'isi_pilihan',
        'bobot'
    ];

    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id', 'id');
    }
}
