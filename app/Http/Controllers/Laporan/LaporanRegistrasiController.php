<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Masters\Program;
use App\Models\Masters\TahunAjaran;
use Illuminate\Http\Request;

class LaporanRegistrasiController extends Controller
{
    public function index(Request $request)
    {
        $listTahunAjaran = TahunAjaran::getListTahunAjaran();
        $listProgram = Program::select('id', 'nama')->get();
        return view('pages.laporan.registrasi.index', [
            'listTahunAjaran' => $listTahunAjaran,
            'listProgram' => $listProgram
        ]);
    }
}
