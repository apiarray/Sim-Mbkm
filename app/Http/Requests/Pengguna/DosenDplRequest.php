<?php

namespace App\Http\Requests\Pengguna;

use Illuminate\Foundation\Http\FormRequest;

class DosenDplRequest extends FormRequest
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
                'nip' => 'required|string|max:50',
                'nama' => 'required|string',
                'email' => 'required|email|unique:dosen_dpl,email,' . $id,
                'password' => 'nullable|confirmed',
                'no_telp' => 'nullable|numeric',
                'fakultas_id' => 'required|exists:fakultas,id',
            ];
        } else {
            $validation = [
                'nip' => 'required|string|max:50',
                'nama' => 'required|string',
                'email' => 'required|email|unique:dosen_dpl,email,' . $id,
                'password' => 'required|confirmed',
                'no_telp' => 'nullable|numeric',
                'fakultas_id' => 'required|exists:fakultas,id',
            ];
        }
        return $validation;
    }
}
