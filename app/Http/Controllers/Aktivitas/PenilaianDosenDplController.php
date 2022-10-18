<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\JawabanPenilaian;
use App\Models\Aktivitas\PenilaianDosenDpl;
use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\Masters\BabPenilaian;
use App\Models\Masters\PilihanPenilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenilaianDosenDplController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.aktivitas.penilaian-dosen-dpl.index');
    }

    public function listPenilaianDosenDpl(Request $request)
    {
        $data = PenilaianDosenDpl::listPenilaianDosenDpl(1);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return json_encode($row);
            })
            ->rawColumns(['action'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id')
            ->where('status_validasi', 'tervalidasi')
            ->where('is_accepted', 1)
            ->whereNotIn('id', PenilaianDosenDpl::select('registrasi_mbkm_id')->get()->pluck('registrasi_mbkm_id'));

        if (auth()->guard('dosen')->check()) {
            $listRegistrasiMbkm->where('dosen_dpl_id', '=', auth()->guard('dosen')->user()->id);
        }

        $listRegistrasiMbkm = $listRegistrasiMbkm->get();

        return view('pages.aktivitas.penilaian-dosen-dpl.create', [
            'listRegistrasiMbkm' => $listRegistrasiMbkm
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'registrasi_mbkm_id' => 'required|exists:registrasi_mbkm,id',
        ]);

        $data = new PenilaianDosenDpl;
        $data->registrasi_mbkm_id   = $request->registrasi_mbkm_id;
        // $data->nilai                = $request->nilai;
        // $data->tanggal_penilaian    = $request->tanggal_penilaian;
        // $data->status               = $request->status;
        $data->save();

        return redirect()->route('aktivitas.penilaian_dosen_dpl.index')->with('message', 'penilaian dosen dpl successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataPenilaianDosen = PenilaianDosenDpl::find($id);

        $dataSoal = BabPenilaian::with('penilaian.pilihan_penilaian')->get();
        $dataJawaban = JawabanPenilaian::where('penilaian_dosen_dpl_id', $id)->get();

        return view('pages.aktivitas.penilaian-dosen-dpl.detail', [
            'dataPenilaianDosen' => $dataPenilaianDosen,
            'dataSoal' => $dataSoal,
            'dataJawaban' => $dataJawaban,
        ]);
    }

    public function storePenilaian(Request $request, $id)
    {

        $request->validate([
            'tanggal_penilaian' => 'required|date',
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|exists:pilihan_penilaian,id',
        ]);
        // dd($request->all());

        DB::beginTransaction();

        $totalNilai = 0;
        $x = [];

        foreach ($request->jawaban as $penilaianId => $pilihanPenilaianId) {
            $pilihan = PilihanPenilaian::find($pilihanPenilaianId);
            $bobot = $pilihan->penilaian->bab_penilaian->bobot ?? 0;
            // dd($bobot * $pilihan->bobot);

            $jawab = JawabanPenilaian::where('penilaian_dosen_dpl_id', $id)->where('penilaian_id', $penilaianId)->first();
            if (!$jawab) {
                $jawab = new JawabanPenilaian;
                $jawab->penilaian_dosen_dpl_id = $id;
                $jawab->penilaian_id = $penilaianId;
            }
            $jawab->pilihan_penilaian_id = $pilihanPenilaianId;
            $jawab->bobot = $pilihan->bobot;
            $jawab->nilai = $pilihan->bobot;
            $jawab->save();

            $totalNilai += ($bobot * $pilihan->bobot);
            $x[] = $bobot * $pilihan->bobot;
        }

        $dataPenilaianDosen = PenilaianDosenDpl::find($id);
        $dataPenilaianDosen->id_penilaian = generateRandomString(10, 4);
        $dataPenilaianDosen->tanggal_penilaian = $request->tanggal_penilaian;
        $dataPenilaianDosen->nilai = $totalNilai;
        $dataPenilaianDosen->nilai_raw = $totalNilai;
        $dataPenilaianDosen->status = 'tervalidasi';
        $dataPenilaianDosen->save();

        DB::commit();

        return redirect()->route('aktivitas.penilaian_dosen_dpl.index')->with('message', 'pengisian penilaian dosen dpl successfully saved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataPenilaianDosen = PenilaianDosenDpl::find($id);
        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id')
            ->where('status_validasi', 'tervalidasi')
            ->where('is_accepted', 1)
            ->whereNotIn(
                'id',
                PenilaianDosenDpl::select('registrasi_mbkm_id')
                    ->where('registrasi_mbkm_id', '!=', $dataPenilaianDosen->registrasi_mbkm_id)
                    ->get()->pluck('registrasi_mbkm_id')
            )
            ->get();

        return view('pages.aktivitas.penilaian-dosen-dpl.edit', [
            'dataPenilaianDosen' => $dataPenilaianDosen,
            'listRegistrasiMbkm' => $listRegistrasiMbkm
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'registrasi_mbkm_id' => 'required|exists:registrasi_mbkm,id',
        ]);

        $data = PenilaianDosenDpl::find($id);
        if (!$data) {
            return redirect()->back()->withInput()->with('error', 'penilaian dosen dpl not found');
        }
        $data->registrasi_mbkm_id   = $request->registrasi_mbkm_id;
        // $data->nilai                = $request->nilai;
        // $data->tanggal_penilaian    = $request->tanggal_penilaian;
        // $data->status               = $request->status;
        $data->save();

        return redirect()->back()->with('message', 'penilaian dosen dpl successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
