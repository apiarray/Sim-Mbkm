<?php

namespace App\Models\Masters;

use App\Models\aktivitas\LogbookHarian;
use App\Models\Aktivitas\LogbookMingguan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'program';
    protected $fillable = [
        'nama'
    ];

    public function LogbookHarian()
    {
        return $this->hasMany(LogbookHarian::class);
    }

    public function LogbookMingguan()
    {
        return $this->hasMany(LogbookMingguan::class);
    }
}
