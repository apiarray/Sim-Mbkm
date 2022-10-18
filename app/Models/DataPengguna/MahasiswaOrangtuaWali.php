<?php

namespace App\Models\DataPengguna;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MahasiswaOrangtuaWali extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mahasiswa_orangtua_wali';
}
