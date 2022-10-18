<?php

namespace App\Models\Pengguna;

use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\KotaKabupaten;
use App\Models\Masters\Kelas;
use App\Models\Masters\TahunAjaran;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'password',
        'status',
        'jenis_pendaftaran',
        'email_kampus',
        'tahun_masuk',
        'nik',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telp',
        'alamat',
        'alamat_rt',
        'alamat_rw',
        'alamat_dusun',
        'alamat_desa_kelurahan',
        'alamat_kecamatan',
        'alamat_kota_id',
        'alamat_kode_pos',
        'asal_instansi',
        'nisn',
        'jenis_kelamin',
        'remember_token',
    ];

    /**
     * 
     * Perlu analisa lagi terkait kelas/jurusan dari mahasiswa
     * jika kelas/jurusan masuk ke Log/History, maka perlu di cek bagaimana relasinya 
     * 
     */

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
    
    public function alamat_kota()
    {
        return $this->belongsTo(KotaKabupaten::class, 'alamat_kota_id', 'id');
    }

    public function registrasi_mbkm()
    {
        return $this->hasMany(RegistrasiMbkm::class, 'mahasiswa_id', 'id');
    }

    public function registrasi_mbkm_aktif()
    {
        return $this->hasOne(RegistrasiMbkm::class, 'mahasiswa_id', 'id')->where('status_validasi', 'tervalidasi')->orderBy('tanggal_registrasi', 'desc');
    }

    public function registrasi_mbkm_terakhir()
    {
        return $this->hasOne(RegistrasiMbkm::class, 'mahasiswa_id', 'id')->orderBy('tanggal_registrasi', 'desc');
    }
}
