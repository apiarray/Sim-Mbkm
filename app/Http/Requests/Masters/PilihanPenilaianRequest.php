<?php

namespace App\Http\Requests\Masters;

use App\Models\Masters\PilihanPenilaian;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PilihanPenilaianRequest extends FormRequest
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
        $idPenilaian = $this->route('id');
        $idPilihanPenilaian = $this->route('id_pilihan');
        $maxBobot = 10 - PilihanPenilaian::where('penilaian_id', '=', $idPenilaian)->where('id', '!=', $idPilihanPenilaian)->sum('bobot');
        $exist = PilihanPenilaian::find($idPilihanPenilaian);
        // dd($idPenilaian, $maxBobot, $existUrutan);
        return [
            'penilaian_id' => 'required|exists:penilaian,id',
            'isi_pilihan' => 'required|string',
            'bobot' => 'required|numeric|min:1|max:' . $maxBobot
        ];
    }
}
