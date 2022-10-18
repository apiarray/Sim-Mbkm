<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontenlanding extends Model
{
	//protected $guarded = [];
    use HasFactory;
	protected $table = 'konten-landings';
    protected $fillable = [
        'judul',
		'isi',
		'jenis',
		'aktif',
    ];
}
