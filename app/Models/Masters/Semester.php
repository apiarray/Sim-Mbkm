<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'semester';
    protected $fillable = [
        'nama'
    ];

    public function program()
    {
        return $this->hasMany(TahunAjaran::class);
    }
}
