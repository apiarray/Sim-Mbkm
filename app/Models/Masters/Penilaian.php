<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penilaian';
    protected $fillable = [
        'bab_penilaian_id',
        'soal_penilaian',
        'bobot'
    ];


    public function bab_penilaian()
    {
        return $this->belongsTo(BabPenilaian::class, 'bab_penilaian_id', 'id');
    }

    public function pilihan_penilaian()
    {
        return $this->hasMany(PilihanPenilaian::class, 'penilaian_id', 'id');
    }
}
