<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdentitasUniversitas extends Model
{
    use HasFactory, SoftDeletes;

    public const PROP_KODE = 'kode';
    public const PROP_NAMA = 'nama';
    public const PROP_ALAMAT = 'alamat';
    public const PROP_NO_TELP = 'no. telp';
    public const PROP_EMAIL = 'email';
    public const PROP_WEBSITE = 'website';
    public const PROP_REKTOR = 'rektor';
    public const PROP_LOGO = 'logo';

    protected $table = 'identitas_universitas';
    protected $fillable = [
        'property',
        'value'
    ];
}
