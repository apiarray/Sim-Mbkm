<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabPenilaian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bab_penilaian';
    protected $fillable = [
        'nama_bab',
        'bobot',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'bab_penilaian_id', 'id');
    }
}
