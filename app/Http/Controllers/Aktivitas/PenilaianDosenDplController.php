<?php

namespace App\Http\Controllers\Aktivitas;

use Barryvdh\DomPDF\PDF;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\JawabanPenilaian;
use App\Models\Aktivitas\PenilaianDosenDpl;
use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\Masters\BabPenilaian;
use App\Models\Masters\PilihanPenilaian;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
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
            ->filterColumn('ttanggal_penilaian', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(penilaian_dosen_dpl.tanggal_penilaian,'%d-%m-%Y') like ?", ["%{$keyword}%"]);
            })
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

    public function cetak($id)
    {
        //penilaian dosen
        $penilaian = PenilaianDosenDpl::find($id);
        $dataSoal = BabPenilaian::with('penilaian.pilihan_penilaian')->get();
        $dataJawaban = JawabanPenilaian::where('penilaian_dosen_dpl_id', $id)->get();


        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id', 'program_id', 'dosen_dpl_id', 'tanggal_registrasi', 'tanggal_validasi')
            ->where('status_validasi', 'tervalidasi')
            ->where('is_accepted', 1)
            ->whereNotIn(
                'id',
                PenilaianDosenDpl::select('registrasi_mbkm_id')
                    ->where('registrasi_mbkm_id', '!=', $penilaian->registrasi_mbkm_id)
                    ->get()->pluck('registrasi_mbkm_id')
            )
            ->get();


        $id_mahasiswa = $listRegistrasiMbkm[0]->mahasiswa_id;
        $id_program = $listRegistrasiMbkm[0]->program_id;
        $id_dosen = $listRegistrasiMbkm[0]->dosen_dpl_id;
        $tanggal_registrasi = $listRegistrasiMbkm[0]->tanggal_registrasi;
        $tanggal_validasi = $listRegistrasiMbkm[0]->tanggal_validasi;
        // $newDateFormat = $tanggal_registrasi->format('d/m/Y');
        // memanggil mahasiswa
        $tgl_regis = Carbon::parse($tanggal_registrasi)->format('d/m/Y');
        $tgl_valid = Carbon::parse($tanggal_validasi)->format('d/m/Y');

        $m = DB::table('mahasiswa')->where('id', $id_mahasiswa)->get();
        // memanggil program
        $p = DB::table('program')->where('id', $id_program)->get();

        // memanggil dosen
        $d = DB::table('dosen_dpl')->where('id', $id_dosen)->get();



        $data = FacadePdf::loadview(
            'pages.aktivitas.penilaian-dosen-dpl.cetak',
            [
                'penilaian' => $penilaian, 'listRegistrasiMbkm' => $listRegistrasiMbkm,
                'm' => $m, 'p' => $p, 'd' => $d, 'dataSoal' => $dataSoal, 'dataJawaban' => $dataJawaban,
                'tgl_regis' => $tgl_regis, 'tgl_valid' => $tgl_valid,
            ],
        );

        return $data->stream();
        // return dwonload('penilaian_dosen_dpl.pdf');

        // echo $users;
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
        PenilaianDosenDpl::find($id)->delete();

        return redirect('dashboard/aktivitas/penilaian-dosen-dpl')->with('penilaian dosen dpl delete success');
    }
}
