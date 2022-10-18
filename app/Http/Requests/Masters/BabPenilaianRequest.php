<?php

namespace App\Http\Requests\Masters;

use App\Models\Masters\BabPenilaian;
use Illuminate\Foundation\Http\FormRequest;

class BabPenilaianRequest extends FormRequest
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
        $maxBobot = 1 - BabPenilaian::where('id', '!=', $id)->sum('bobot');
        return [
            'nama_bab' => 'required|string',
            'bobot' => 'required|numeric|max:' . $maxBobot
        ];
    }
}
