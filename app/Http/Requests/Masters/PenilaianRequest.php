<?php

namespace App\Http\Requests\Masters;

use Illuminate\Foundation\Http\FormRequest;

class PenilaianRequest extends FormRequest
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
        return [
            'bab_penilaian_id' => 'required|exists:bab_penilaian,id',
            'soal_penilaian' => 'required|string',
            'bobot' => 'nullable|numeric'
        ];
    }
}
