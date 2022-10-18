<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenjang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jenjang';
    protected $fillable = [
        'nama',
        'kode'
    ];

    public function fakultas()
    {
        return $this->hasMany(Fakultas::class);
    }
}
