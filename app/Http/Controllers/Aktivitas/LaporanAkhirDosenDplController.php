<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\LaporanAkhirDosenDpl;
use App\Models\Aktivitas\LaporanAkhirDosenDplDetail;
use App\Models\Masters\TahunAjaran;
use App\Models\Pengguna\DosenDpl;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanAkhirDosenDplController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.aktivitas.laporan.dosen-dpl.index");
    }

    public function listLaporanAkhirDosenDpl(Request $request)
    {
        $data = LaporanAkhirDosenDpl::listLaporanAkhirDosenDpl(1);
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
        $listTahunAjaran = TahunAjaran::getListTahunAjaran();
        $listDosen = DosenDpl::get();
        return view("pages.aktivitas.laporan.dosen-dpl.create", [
            'listTahunAjaran' => $listTahunAjaran,
            'listDosen' => $listDosen,
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
            'dosen_dpl_id' => 'required|exists:dosen_dpl,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_laporan' => 'required|date',
            'registrasi_mbkm_id' => 'required|array',
            'registrasi_mbkm_id.*' => 'required|exists:registrasi_mbkm,id',
            'beban_jam_log_harian' => 'required|array',
            'beban_jam_log_harian.*' => 'required|numeric|min:0',
            'beban_jam_log_mingguan' => 'required|array',
            'beban_jam_log_mingguan.*' => 'required|numeric|min:0',
            'beban_jam_laporan_akhir' => 'required|array',
            'beban_jam_laporan_akhir.*' => 'required|numeric|min:0',
        ]);

        if (
            (count($request->beban_jam_log_harian) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_log_mingguan) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_laporan_akhir) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_log_harian) != count($request->beban_jam_log_mingguan)) ||
            (count($request->beban_jam_log_mingguan) != count($request->beban_jam_laporan_akhir)) ||
            (count($request->beban_jam_log_harian) != count($request->beban_jam_laporan_akhir))
        ) {
            return redirect()->back()->withInput()->with('error', 'Data rincian laporan akhir tidak valid!');
        }

        DB::beginTransaction();
        $lapAkhir = new LaporanAkhirDosenDpl;
        $lapAkhir->id_laporan_akhir_dosen_dpl   = generateRandomString(10, 4);
        $lapAkhir->dosen_dpl_id                 = $request->dosen_dpl_id;
        $lapAkhir->tahun_ajaran_id              = $request->tahun_ajaran_id;
        $lapAkhir->tanggal_laporan_akhir        = $request->tanggal_laporan;
        $lapAkhir->save();

        foreach ($request->registrasi_mbkm_id as $idx => $idReg) {
            $lapAkhirDetail = new LaporanAkhirDosenDplDetail;
            $lapAkhirDetail->laporan_akhir_dosen_dpl_id = $lapAkhir->id;
            $lapAkhirDetail->registrasi_mbkm_id = $idReg;
            $lapAkhirDetail->beban_jam_log_harian = $request->beban_jam_log_harian[$idx] ?? 0;
            $lapAkhirDetail->beban_jam_log_mingguan = $request->beban_jam_log_mingguan[$idx] ?? 0;
            $lapAkhirDetail->beban_jam_laporan_akhir = $request->beban_jam_laporan_akhir[$idx] ?? 0;
            $lapAkhirDetail->save();
        }

        DB::commit();

        return redirect()->route('aktivitas.laporan_akhir.dosen_dpl.index')->with('message', 'Laporan Akhir DPL inserted sucessfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function print($id)
    {
        $dataLaporanAkhir = LaporanAkhirDosenDpl::select('laporan_akhir_dosen_dpl.*', 'dosen_dpl.nama as nama_dosen', 'tahun_ajaran.tahun_ajaran', 'semester.nama as semester')
            ->join('dosen_dpl', 'dosen_dpl.id', 'laporan_akhir_dosen_dpl.dosen_dpl_id')
            ->join('tahun_ajaran', 'tahun_ajaran.id', 'laporan_akhir_dosen_dpl.tahun_ajaran_id')
            ->join('semester', 'semester.id', 'tahun_ajaran.semester_id')
            ->find($id);
        // dd($dataLaporanAkhir);
        $dataLaporanAkhirDetail = LaporanAkhirDosenDplDetail::select(
            'laporan_akhir_dosen_dpl_detail.*',
            'registrasi_mbkm.id_registrasi',
            'penilaian_dosen_dpl.id_penilaian',
            'penilaian_dosen_dpl.tanggal_penilaian',
            'mahasiswa.nama as nama_mahasiswa',
            'mahasiswa.nim as nim_mahasiswa',
            DB::raw("(SELECT count(*) from logbook_harian where logbook_harian.registrasi_mbkm_id = registrasi_mbkm.id and logbook_harian.status = 'tervalidasi') as count_logbook_harian"),
            DB::raw("(SELECT count(*) from logbook_mingguan where logbook_mingguan.registrasi_mbkm_id = registrasi_mbkm.id and logbook_mingguan.status = 'tervalidasi') as count_logbook_mingguan"),
            DB::raw("(SELECT id_laporan_akhir_mahasiswa from laporan_akhir_mahasiswa where laporan_akhir_mahasiswa.registrasi_mbkm_id = registrasi_mbkm.id order by laporan_akhir_mahasiswa.tanggal_laporan_akhir and laporan_akhir_mahasiswa.status_laporan_akhir = 'validasi' DESC Limit 1) as id_laporan_akhir_mahasiswa")
        )
            ->join('registrasi_mbkm', 'registrasi_mbkm.id', 'laporan_akhir_dosen_dpl_detail.registrasi_mbkm_id')
            ->join('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
            ->leftJoin('penilaian_dosen_dpl', function ($join) {
                $join->on('penilaian_dosen_dpl.registrasi_mbkm_id', 'registrasi_mbkm.id');
                $join->where('penilaian_dosen_dpl.status', 'tervalidasi');
                $join->orderBy('penilaian_dosen_dpl.tanggal_penilaian', 'DESC');
                $join->limit(1);
            })
            ->where('laporan_akhir_dosen_dpl_id', $id)
            ->get();
        $pdf = Pdf::setPaper('a4', 'landscape')->loadView('export.laporan-akhir.dosen-dpl.print-pdf', [
            'dataLaporanAkhir' => $dataLaporanAkhir,
            'dataLaporanAkhirDetail' => $dataLaporanAkhirDetail,
        ]);

        return $pdf->stream('laporan-akhir-dpl_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataLaporanAkhir = LaporanAkhirDosenDpl::find($id);
        $dataLaporanAkhirDetail = LaporanAkhirDosenDplDetail::select(
            'laporan_akhir_dosen_dpl_detail.*',
            'registrasi_mbkm.id_registrasi',
            'penilaian_dosen_dpl.id_penilaian',
            'penilaian_dosen_dpl.tanggal_penilaian',
            'mahasiswa.nama as nama_mahasiswa',
            'mahasiswa.nim as nim_mahasiswa',
            DB::raw("(SELECT count(*) from logbook_harian where logbook_harian.registrasi_mbkm_id = registrasi_mbkm.id and logbook_harian.status = 'tervalidasi') as count_logbook_harian"),
            DB::raw("(SELECT count(*) from logbook_mingguan where logbook_mingguan.registrasi_mbkm_id = registrasi_mbkm.id and logbook_mingguan.status = 'tervalidasi') as count_logbook_mingguan"),
            DB::raw("(SELECT id_laporan_akhir_mahasiswa from laporan_akhir_mahasiswa where laporan_akhir_mahasiswa.registrasi_mbkm_id = registrasi_mbkm.id order by laporan_akhir_mahasiswa.tanggal_laporan_akhir and laporan_akhir_mahasiswa.status_laporan_akhir = 'validasi' DESC Limit 1) as id_laporan_akhir_mahasiswa")
        )
            ->join('registrasi_mbkm', 'registrasi_mbkm.id', 'laporan_akhir_dosen_dpl_detail.registrasi_mbkm_id')
            ->join('mahasiswa', 'mahasiswa.id', 'registrasi_mbkm.mahasiswa_id')
            ->leftJoin('penilaian_dosen_dpl', function ($join) {
                $join->on('penilaian_dosen_dpl.registrasi_mbkm_id', 'registrasi_mbkm.id');
                $join->where('penilaian_dosen_dpl.status', 'tervalidasi');
                $join->orderBy('penilaian_dosen_dpl.tanggal_penilaian', 'DESC');
                $join->limit(1);
            })
            ->where('laporan_akhir_dosen_dpl_id', $id)
            ->get();
        // dd($dataLaporanAkhirDetail);
        $listTahunAjaran = TahunAjaran::getListTahunAjaran();
        $listDosen = DosenDpl::get();
        return view("pages.aktivitas.laporan.dosen-dpl.edit", [
            'dataLaporanAkhir' => $dataLaporanAkhir,
            'dataLaporanAkhirDetail' => $dataLaporanAkhirDetail,
            'listTahunAjaran' => $listTahunAjaran,
            'listDosen' => $listDosen,
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
            'dosen_dpl_id' => 'required|exists:dosen_dpl,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tanggal_laporan' => 'required|date',
            'registrasi_mbkm_id' => 'required|array',
            'registrasi_mbkm_id.*' => 'required|exists:registrasi_mbkm,id',
            'beban_jam_log_harian' => 'required|array',
            'beban_jam_log_harian.*' => 'required|numeric|min:0',
            'beban_jam_log_mingguan' => 'required|array',
            'beban_jam_log_mingguan.*' => 'required|numeric|min:0',
            'beban_jam_laporan_akhir' => 'required|array',
            'beban_jam_laporan_akhir.*' => 'required|numeric|min:0',
        ]);

        if (
            (count($request->beban_jam_log_harian) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_log_mingguan) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_laporan_akhir) != count($request->registrasi_mbkm_id)) ||
            (count($request->beban_jam_log_harian) != count($request->beban_jam_log_mingguan)) ||
            (count($request->beban_jam_log_mingguan) != count($request->beban_jam_laporan_akhir)) ||
            (count($request->beban_jam_log_harian) != count($request->beban_jam_laporan_akhir))
        ) {
            return redirect()->back()->withInput()->with('error', 'Data rincian laporan akhir tidak valid!');
        }

        DB::beginTransaction();
        $lapAkhir = LaporanAkhirDosenDpl::find($id);
        $lapAkhir->id_laporan_akhir_dosen_dpl   = generateRandomString(10, 4);
        $lapAkhir->dosen_dpl_id                 = $request->dosen_dpl_id;
        $lapAkhir->tahun_ajaran_id              = $request->tahun_ajaran_id;
        $lapAkhir->tanggal_laporan_akhir        = $request->tanggal_laporan;
        $lapAkhir->save();

        $oldDetail = LaporanAkhirDosenDplDetail::where('laporan_akhir_dosen_dpl_id', $id)->get();

        foreach ($request->registrasi_mbkm_id as $idx => $idReg) {
            if ($oldDetail->isNotEmpty()) {
                $lapAkhirDetail = $oldDetail->shift();
            } else {
                $lapAkhirDetail = new LaporanAkhirDosenDplDetail;
            }
            $lapAkhirDetail->laporan_akhir_dosen_dpl_id = $lapAkhir->id;
            $lapAkhirDetail->registrasi_mbkm_id = $idReg;
            $lapAkhirDetail->beban_jam_log_harian = $request->beban_jam_log_harian[$idx] ?? 0;
            $lapAkhirDetail->beban_jam_log_mingguan = $request->beban_jam_log_mingguan[$idx] ?? 0;
            $lapAkhirDetail->beban_jam_laporan_akhir = $request->beban_jam_laporan_akhir[$idx] ?? 0;
            $lapAkhirDetail->save();
        }

        if ($oldDetail->isNotEmpty()) {
            foreach ($oldDetail as $dtl) {
                $dtl->delete();
            }
        }

        DB::commit();

        return redirect()->route('aktivitas.laporan_akhir.dosen_dpl.index')->with('message', 'Laporan Akhir DPL updated sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        LaporanAkhirDosenDplDetail::where('laporan_akhir_dosen_dpl_id', $id)->delete();
        LaporanAkhirDosenDpl::find($id)->delete();
        DB::commit();

        return redirect()->route('aktivitas.laporan_akhir.dosen_dpl.index')->with('message', 'Laporan Akhir DPL deleted sucessfully!');
    }
}
