<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\LaporanAkhirMahasiswa;
use App\Models\Aktivitas\LaporanAkhirMahasiswaDetail;
use App\Models\Aktivitas\RegistrasiMbkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanAkhirMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pages.aktivitas.laporan.mahasiswa.index");
    }

    public function listLaporanAkhirMahasiswa(Request $request)
    {
        $data = LaporanAkhirMahasiswa::listLaporanAkhirMahasiswa(1);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return json_encode($row);
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function getByRegistrasiId($registrasi_mbkm_id)
    {
        $data = LaporanAkhirMahasiswa::listLaporanAkhirMahasiswa(1);
        $data = $data->where('registrasi_mbkm_id', $registrasi_mbkm_id);
        $data = $data->orderBy('tanggal_laporan_akhir', 'DESC');
        $data = $data->orderBy('laporan_akhir_mahasiswa.created_at', 'DESC');
        $data = $data->first();

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        // $dataLaporan_akhir = LaporanAkhir::get();
        $dataLaporanAkhir = DB::table('registrasi_mbkm as a')
            ->leftjoin('logbook_mingguan as b', 'a.id', '=', 'b.registrasi_mbkm_id')
            ->select('a.*', 'b.*', 'b.id as id_logbook_mingguan')
            ->where('a.status_validasi', '=', 'tervalidasi')
            ->get();
        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id')
            ->where('status_validasi', 'tervalidasi')
            ->where('is_accepted', 1)
            ->get();
        // dd($dataLaporanAkhir); 
        return view('pages.aktivitas.laporan.mahasiswa.create', compact('dataLaporanAkhir', 'listRegistrasiMbkm'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'materi_pdf' => 'nullable|mimetypes:application/pdf',
            'link_video' => 'nullable|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
            'judul_materi' => 'required',
            'link_youtube' => 'nullable',
            'tanggal_laporan' => 'required|date',
            'deskripsi' => 'required',
            'id_logbook_mingguan' => 'required|array'
        ]);
        $materipdf = NULL;
        $video = NULL;
        if ($request->file('materi_pdf')) {
            $materipdf = request()->file('materi_pdf')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $video = request()->file('link_video')->store('video/' . date('Y'), 'public');
        }


        DB::beginTransaction();
        $insertData =  new LaporanAkhirMahasiswa();

        $insertData->registrasi_mbkm_id = $request->id_validasi_reg;
        if ($materipdf) {
            $insertData->materi_pdf = $materipdf;
        }
        if ($video) {
            $insertData->link_video = $video;
        }

        $insertData->judul_materi = $request->judul_materi;
        $insertData->link_youtube = $request->link_youtube;
        $insertData->deskripsi = $request->deskripsi;
        // $insertData->id_log_book_mingguan = $request->id_logbook_mingguan;
        $insertData->tanggal_laporan_akhir = $request->tanggal_laporan;
        // $insertData->status_laporan_akhir = $request->semester_akhir;
        $insertData->save();

        for ($i = 0; $i < count($request['id_logbook_mingguan']); $i++) {
            $insertDataDetail = new LaporanAkhirMahasiswaDetail();
            $insertDataDetail->id_log_book_mingguan = (int) $request['id_logbook_mingguan'][$i];
            $insertDataDetail->laporan_akhir_mahasiswa_id = (int)$insertData->id;
            $insertDataDetail->save();
        }
        DB::commit();

        return redirect('dashboard/aktivitas/laporan-akhir/mahasiswa')->with('message', 'Laporan Akhir Mahasiswa successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataRegistrasiMbkm = DB::table('registrasi_mbkm as a')
            ->leftjoin('logbook_mingguan as b', 'a.id', '=', 'b.registrasi_mbkm_id')
            ->leftjoin('mahasiswa as c', 'a.mahasiswa_id', '=', 'c.id')
            ->leftjoin('tahun_ajaran as e', 'a.tahun_ajaran_id', '=', 'e.id')
            ->leftjoin('semester as d', 'e.semester_id', '=', 'd.id')
            ->select('a.*', 'a.id as id_registrasi_mbkm', 'b.registrasi_mbkm_id', 'b.judul', 'b.id as id_log_mingguan', 'c.nama as nama_mahasiswa', 'd.id as id_semester', 'd.nama as nama_semester', 'e.*')
            ->where('a.status_validasi', '=', 'tervalidasi')
            ->where('a.is_accepted', 1)
            ->get();
        $dataLogbookmingguan = LaporanAkhirMahasiswa::find($id);


        $dataLogbookmingguanDetail = DB::table('logbook_mingguan as a')
            ->join('registrasi_mbkm as c', 'c.id', 'a.registrasi_mbkm_id')
            ->leftjoin('laporan_akhir_mahasiswa_detail as b', function ($join) use ($id) {
                $join->on('b.id_log_book_mingguan', '=', 'a.id');
                $join->where('b.laporan_akhir_mahasiswa_id', '=', $id);
            })
            ->where('a.status', '=', 'tervalidasi')
            ->where('c.id', '=', ($dataLogbookmingguan->registrasi_mbkm_id ?? NULL))
            ->select('a.id', 'b.id_log_book_mingguan', 'a.judul')
            ->get();
        return view('pages.aktivitas.laporan.mahasiswa.show', compact('dataRegistrasiMbkm', 'dataLogbookmingguan', 'dataLogbookmingguanDetail'));
    }

    public function validatemahasiswa(Request $request, $id)
    {
        $dataLaporanAkhir = LaporanAkhirMahasiswa::find($id);
        if (!$dataLaporanAkhir) {
            return redirect()->back()->with('message', 'logbook Mingguan tidak ditemukan');
        }

        $request->validate([
            'status' => 'required|in:validasi,revisi,mengajukan,dalam_proses'
        ]);

        if ($request->status == 'validasi') {
            $dataLaporanAkhir->id_laporan_akhir_mahasiswa = generateRandomString(10, 4);
        } else if ($request->status == 'revisi') {
            $dataLaporanAkhir->id_laporan_akhir_mahasiswa = NULL;
        } else if ($request->status == 'dalam_proses') {
            $dataLaporanAkhir->id_laporan_akhir_mahasiswa = NULL;
        } else if ($request->status == 'mengajukan') {
            $dataLaporanAkhir->id_laporan_akhir_mahasiswa = NULL;
        }

        $dataLaporanAkhir->status_laporan_akhir = $request->status;
        $dataLaporanAkhir->save();

        return redirect()->back()->with('message', 'laporan akhir mahasiswa successfully submited');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $dataRegistrasiMbkm = DB::table('registrasi_mbkm as a')
            ->leftjoin('logbook_mingguan as b', 'a.id', '=', 'b.registrasi_mbkm_id')
            ->leftjoin('mahasiswa as c', 'a.mahasiswa_id', '=', 'c.id')
            ->leftjoin('tahun_ajaran as e', 'a.tahun_ajaran_id', '=', 'e.id')
            ->leftjoin('semester as d', 'e.semester_id', '=', 'd.id')
            ->select('a.*', 'a.id as id_registrasi_mbkm', 'b.registrasi_mbkm_id', 'b.judul', 'b.id as id_log_mingguan', 'c.nama as nama_mahasiswa', 'd.id as id_semester', 'd.nama as nama_semester', 'e.*')
            ->where('a.status_validasi', '=', 'tervalidasi')
            ->where('a.is_accepted', 1)
            ->get();
        $dataLogbookmingguan = LaporanAkhirMahasiswa::find($id);


        $dataLogbookmingguanDetail = DB::table('logbook_mingguan as a')
            ->join('registrasi_mbkm as c', 'c.id', 'a.registrasi_mbkm_id')
            ->leftjoin('laporan_akhir_mahasiswa_detail as b', function ($join) use ($id) {
                $join->on('b.id_log_book_mingguan', '=', 'a.id');
                $join->where('b.laporan_akhir_mahasiswa_id', '=', $id);
            })
            ->where('a.status', '=', 'tervalidasi')
            ->where('c.id', '=', ($dataLogbookmingguan->registrasi_mbkm_id ?? NULL))
            ->select('a.id', 'b.id_log_book_mingguan', 'a.judul')
            ->get();


        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id')
            ->where('status_validasi', 'tervalidasi')
            ->where('is_accepted', 1)
            ->get();

        return view('pages.aktivitas.laporan.mahasiswa.edit', compact('dataLogbookmingguan', 'dataRegistrasiMbkm', 'listRegistrasiMbkm', 'dataLogbookmingguanDetail'));
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
        //
        $this->validate($request, [
            'id_logbook_mingguan' => 'required',
            'materi_pdf' => 'nullable|mimetypes:application/pdf',
            'link_video' => 'nullable|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv',
            'judul_materi' => 'required',
            'link_youtube' => 'nullable',
            'tanggal_laporan' => 'required',
            'deskripsi' => 'nullable'
        ]);
        $cek = LaporanAkhirMahasiswa::find($id);
        if (!$cek) {
            return redirect()->back()->with('error', 'Laporan Akhir tidak ditemukan');
        }

        DB::beginTransaction();

        $materipdf = NULL;
        $video = NULL;
        if ($request->file('materi_pdf')) {
            $materipdf = request()->file('materi_pdf')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $video = request()->file('link_video')->store('video/' . date('Y'), 'public');
        }


        $cek->registrasi_mbkm_id = $request->id_validasi_reg;
        if ($materipdf) {
            $cek->materi_pdf = $materipdf;
        }
        if ($video) {
            $cek->link_video = $video;
        }

        $cek->judul_materi = $request->judul_materi;
        $cek->link_youtube = $request->link_youtube;
        $cek->deskripsi = $request->deskripsi;
        $cek->tanggal_laporan_akhir = $request->tanggal_laporan;
        $cek->save();

        DB::table('laporan_akhir_mahasiswa_detail')->where('laporan_akhir_mahasiswa_id', $cek->id)->delete();
        for ($i = 0; $i < count(array($request['id_logbook_mingguan'])); $i++) {

            $insertDataDetail = new LaporanAkhirMahasiswaDetail();
            $insertDataDetail->id_log_book_mingguan = (int) $request['id_logbook_mingguan'][$i];
            $insertDataDetail->laporan_akhir_mahasiswa_id = (int)$cek->id;
            $insertDataDetail->save();
        }
        DB::commit();
        return redirect('dashboard/aktivitas/laporan-akhir/mahasiswa')->with('message', 'Laporan Akhir successfully updated');
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
        // $delete = DB::table('laporan_akhir_mahasiswa_detail')->where('laporan_akhir_mahasiswa_id', $id)->delete();
        $delete = DB::table('laporan_akhir_mahasiswa')->where('id', $id)->delete();

        if ($delete) {
            request()->session()->flash('message', 'Data Laporan Berhasil DiHapus');
        } else {
            request()->session()->flash('error', 'Data Gagal DiHapus');
        }

        return redirect('dashboard/aktivitas/laporan-akhir/mahasiswa')->with('message', 'Laporan Akhir successfully deleted');
    }

    public function getDataLaporanAkhir(Request $request)
    {
        $body = $request->all();
        $dataLaporanAkhir = DB::table('registrasi_mbkm as a')
            ->leftjoin('logbook_mingguan as b', 'a.id', '=', 'b.registrasi_mbkm_id')
            ->leftjoin('mahasiswa as c', 'a.mahasiswa_id', '=', 'c.id')
            ->leftjoin('dosen_dpl as d', 'a.dosen_dpl_id', '=', 'd.id')
            ->leftjoin('kelas as e', 'a.kelas_id', '=', 'e.id')
            ->leftjoin('jurusan as f', 'e.jurusan_id', '=', 'f.id')
            ->leftjoin('tahun_ajaran as g', 'a.tahun_ajaran_id', '=', 'g.id')
            ->leftjoin('semester as h', 'g.semester_id', '=', 'h.id')
            ->leftjoin('program as i', 'a.program_id', '=', 'i.id')
            ->select('a.*', 'b.*', 'b.id as id_logbook_mingguan', 'c.id as id_mahasiswa', 'c.nama as nama_mahasiswa', 'c.nim as nim_mahasiswa', 'd.nama as nama_dosen', 'e.nama as nama_kelas', 'f.nama as nama_jurusan', 'g.tahun_ajaran', 'h.nama as nama_semester', 'i.nama as nama_program')
            ->where('a.id', '=', $body['id_validasi_reg'])
            ->get();

        $data_log_book = DB::table('logbook_mingguan as a')
            ->leftjoin('registrasi_mbkm as b', 'a.registrasi_mbkm_id', '=', 'b.id')
            ->leftjoin('mahasiswa as c', 'b.mahasiswa_id', '=', 'c.id')
            ->where('c.id', '=', $dataLaporanAkhir[0]->id_mahasiswa)
            ->select('a.*', 'a.id as id_logbook_mingguan', 'b.*', 'b.id as id_registrasi_mbkm', 'c.*', 'c.id as id_mahasiswa')
            ->get();

        // $html_log_mingguan = "";
        // if(isset($test)){
        //     foreach($test as $row){
        //         $html_log_mingguan += '<div class="col">';
        //         $html_log_mingguan += '<input class="form-check-input" type="checkbox" id="gridCheck1" name="id_logbook_mingguan" value="'. $row->id_logbook_mingguan .'">';
        //         $html_log_mingguan += '<label class="form-check-label" for="gridCheck1">';
        //         $html_log_mingguan += $row->judul;
        //         $html_log_mingguan += '</label>';
        //         $html_log_mingguan += '</div>';
        //     }
        //     dd($html_log_mingguan);
        // }


        return [
            'content' => $dataLaporanAkhir,
            'data_log_book' => $data_log_book,
        ];
    }
}
