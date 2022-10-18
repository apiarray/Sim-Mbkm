<?php

namespace App\Http\Requests\Pengguna;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        
        if($id){
            $validation = [
                'nim' => 'required|numeric|unique:mahasiswa,nim,' . $id,
                'nama' => 'required|string',
                'email' => 'required|email|unique:mahasiswa,email,' . $id,
                'password' => 'nullable|confirmed',
                'no_telp' => 'nullable|numeric',
                'tahun_masuk' => 'required|numeric',
                'jenis_kelamin' => 'required|in:pria,wanita',
                'alamat' => 'nullable|string',
                'alamat_rt' => 'nullable|string|max:3',
                'alamat_rw' => 'nullable|string|max:3',
                'alamat_dusun' => 'nullable|string',
                'alamat_desa_kelurahan' => 'nullable|string',
                'alamat_kecamatan' => 'nullable|string',
                'alamat_kode_pos' => 'nullable|string|max:6',
                'alamat_kota_id' => 'required|exists:kota_kabupaten,id',
                'status' => 'required|in:internal,luar_unidha',
                'asal_instansi' => 'nullable|string',
                'nisn' => 'nullable|numeric',
                'jenis_pendaftaran' => 'required|in:baru,pindahan',
            ];
        } else {
            $validation = [
                'nim' => 'required|numeric|unique:mahasiswa,nim',
                'nama' => 'required|string',
                'email' => 'required|email|unique:mahasiswa,email',
                'password' => 'required|confirmed',
                'no_telp' => 'nullable|numeric',
                'tahun_masuk' => 'required|numeric',
                'jenis_kelamin' => 'required|in:pria,wanita',
                'alamat' => 'nullable|string',
                'alamat_rt' => 'nullable|string|max:3',
                'alamat_rw' => 'nullable|string|max:3',
                'alamat_dusun' => 'nullable|string',
                'alamat_desa_kelurahan' => 'nullable|string',
                'alamat_kecamatan' => 'nullable|string',
                'alamat_kode_pos' => 'nullable|string|max:6',
                'alamat_kota_id' => 'required|exists:kota_kabupaten,id',
                'status' => 'required|in:internal,luar_unidha',
                'asal_instansi' => 'nullable|string',
                'nisn' => 'nullable|numeric',
                'jenis_pendaftaran' => 'required|in:baru,pindahan',
            ];
        }
        return $validation;
    }
}
