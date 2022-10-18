<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class KontenRequest extends FormRequest
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
        $kolom = [
            'isi' 				=> 'required|string',
			'judul' 			=> 'required|string',
			'jenis' 			=> 'required|string',
			'tanggal' 			=> 'required',		
			'gambar' 			=> 'nullable|string',
			//'gambar_upload' 	=> 'required|mimes:jpeg,jpg,png',
			'aktif' 			=> 'required|max:255'	
        ];
		
		//print_r($kolom);
		return $kolom;
    }
}
