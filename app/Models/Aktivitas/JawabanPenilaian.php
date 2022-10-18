<?php

namespace App\Models\Aktivitas;

use App\Models\Masters\Penilaian;
use App\Models\Masters\PilihanPenilaian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPenilaian extends Model
{
    use HasFactory;

    protected $table = 'jawaban_penilaian';

    public function pilihan_penilaian()
    {
        return $this->belongsTo(PilihanPenilaian::class, 'pilihan_penilaian_id', 'id');
    }
    
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id', 'id');
    }
}
