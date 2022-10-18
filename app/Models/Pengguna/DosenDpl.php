<?php

namespace App\Models\Pengguna;

use App\Models\Masters\Fakultas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosenDpl extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'dosen_dpl';
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
        'no_telp',
        'fakultas_id',
        'remember_token'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'id');
    }
}
