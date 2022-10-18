<?php

namespace App\Imports\Pengguna;

use App\Models\KotaKabupaten;
use App\Models\Pengguna\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MahasiswaImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function headingRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach($rows as $row){
            $kotaKabId = KotaKabupaten::where('nama', $row['kota_kabupaten'])->first()->id;
            Mahasiswa::create([
                'nim' => $row['nim'],
                'nama' => $row['nama'],
                'email' => $row['email_pribadi'],
                'password' => Hash::make($row['nim']),
                // 'kelas_id' => $row['kode_kelas_perkuliahan'],
                'tahun_masuk' => $row['periode_masuk'],
                'jenis_pendaftaran' => $row['jenis_pendaftaran'] == 'Peserta Didik Baru' ? 'baru' : 'pindahan',
                'status' => 'internal',
                'email_kampus' => $row['email_kampus'],
                'nik' => $row['nik'],
                'agama' => $row['agama'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => Carbon::parse($row['tanggal_lahir'])->format('Y-m-d'),
                'no_telp' => $row['hp'],
                'alamat' => $row['alamat'],
                'alamat_rt' => $row['rt'],
                'alamat_rw' => $row['rw'],
                'alamat_dusun' => $row['dusun'],
                'alamat_desa_kelurahan' => $row['desa_kelurahan'],
                'alamat_kecamatan' => $row['kecamatan'],
                'alamat_kota_id' => $kotaKabId,
                'alamat_kode_pos' => $row['kode_pos'],
                'asal_instansi' => $row['asal_instansi'],
                'nisn' => $row['nisn'],
                'jenis_kelamin' => $row['jk'],
            ]);
        }
    }

    /**
     * VALIDATION
     */
    public function rules(): array
    {
        // return [];
        return [
            'nim' => 'required|unique:mahasiswa,nim',
            'nama' => 'required|string',
            'email_pribadi' => 'required|email|unique:mahasiswa,email',
            'periode_masuk' => 'required|numeric|digits:4',
            'nik' => 'nullable|numeric',
            'agama' => [
                'required',
                'string',
                Rule::in(['Islam','Kristen','Katolik','Budha','Hindu','Konghucu'])
            ],
            'jk' => [
                'required',
                'string',
                Rule::in(['Pria', 'Wanita'])
            ],
            'jenis_pendaftaran' => 'required|string|in:Peserta Didik Baru,Pindahan',
            'kota_kabupaten' => 'nullable|exists:kota_kabupaten,nama'
        ];
    }
}
