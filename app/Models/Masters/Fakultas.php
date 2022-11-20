<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fakultas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fakultas';
    protected $timestamp = true;
    protected $fillable = [
        'nama',
        'kode',
        'jenjang_id'
    ];



    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_id', 'id');
    }

    public function jurusan()
    {
        return $this->hasMany(Jurusan::class);
    }
}
