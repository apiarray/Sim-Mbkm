<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas\LogbookMingguan;
use App\Models\Aktivitas\RegistrasiMbkm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogBookMingguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.aktivitas.logbook.mingguan.index');
    }

    public function listLogMingguanDatatable(Request $request)
    {
        $data = LogbookMingguan::listLogbookMingguan(1);

        return DataTables::of($data)
            ->addIndexColumn()
            ->filterColumn('ttanggal', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(logbook_mingguan.tanggal,'%d-%m-%Y') like ?", ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($row) {
                return json_encode($row);
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function listLogMingguan(Request $request)
    {
        $data = LogbookMingguan::listLogbookMingguan(1);

        if ($request->status == LogbookMingguan::STATUS_TERVALIDASI) {
            $data = $data->where('logbook_mingguan.status', LogbookMingguan::STATUS_TERVALIDASI);
        } else if ($request->status == LogbookMingguan::STATUS_MENGAJUKAN) {
            $data = $data->where('logbook_mingguan.status', LogbookMingguan::STATUS_MENGAJUKAN);
        } else if ($request->status == LogbookMingguan::STATUS_REVISI) {
            $data = $data->where('logbook_mingguan.status', LogbookMingguan::STATUS_REVISI);
        }

        if ($request->registrasi_mbkm_id) {
            $data = $data->where('registrasi_mbkm.id', $request->registrasi_mbkm_id);
        }

        return $data->get();
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
            ->get();
        return view('pages.aktivitas.logbook.mingguan.create', [
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
        // dd($request);
        $request->validate([
            'registrasi_mbkm_id' => 'required|exists:registrasi_mbkm,id',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'link_dokumen' => 'nullable|file|mimetypes:application/pdf|max:5120', // 5MB
            // 'link_video' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'link_video' => 'nullable|file|mimetypes:image/bmp,image/gif,image/jpeg,image/png|max:5120', // 5MB
            'link_youtube' => 'nullable|string|starts_with:http,https',
            'minggu' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $pathDokumen = NULL;
        $pathVideo = NULL;
        if ($request->file('link_dokumen')) {
            $pathDokumen = request()->file('link_dokumen')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $pathVideo = request()->file('link_video')->store('gambar/' . date('Y'), 'public');
        }

        $lb = new LogbookMingguan;
        $lb->minggu = $request->minggu;
        $lb->registrasi_mbkm_id = $request->registrasi_mbkm_id;
        if ($pathDokumen) {
            $lb->link_dokumen = $pathDokumen;
        }
        if ($pathVideo) {
            $lb->link_video = $pathVideo;
        }
        $lb->link_youtube = $request->link_youtube;
        $lb->judul = $request->judul;
        $lb->deskripsi = $request->deskripsi;
        $lb->tanggal = $request->tanggal;
        $lb->status = 'mengajukan';
        $lb->save();

        return redirect()->back()->with('message', 'logbook mingguan successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataLogbookMingguan = LogbookMingguan::find($id);
        return view('pages.aktivitas.logbook.mingguan.show', [
            'dataLogbookMingguan' => $dataLogbookMingguan
        ]);
    }

    public function validateForm($id)
    {
        $dataLogbookMingguan = LogbookMingguan::find($id);
        return view('pages.aktivitas.logbook.mingguan.validate', [
            'dataLogbookMingguan' => $dataLogbookMingguan
        ]);
    }

    public function validateLogbook(Request $request, $id)
    {
        $dataLogbookMingguan = LogbookMingguan::find($id);
        if (!$dataLogbookMingguan) {
            return redirect()->back()->with('message', 'logbook mingguan tidak ditemukan');
        }

        $request->validate([
            'status' => 'required|in:mengajukan,dalam_proses,revisi,tervalidasi'
        ]);

        if ($request->status == 'tervalidasi') {
            $dataLogbookMingguan->id_log_mingguan = generateRandomString(10, 4);
        } else if ($request->status == 'mengajukan') {
            $dataLogbookMingguan->id_log_mingguan = NULL;
        } else if ($request->status == 'dalam_proses') {
            $dataLogbookMingguan->id_log_mingguan = NULL;
        } else if ($request->status == 'revisi') {
            $dataLogbookMingguan->id_log_mingguan = NULL;
        }

        $dataLogbookMingguan->status = $request->status;
        $dataLogbookMingguan->save();

        return redirect()->back()->with('message', 'logbook mingguan successfully submited');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listRegistrasiMbkm = RegistrasiMbkm::select('id', 'id_registrasi', 'mahasiswa_id')->where('status_validasi', 'tervalidasi')->get();
        $dataLogbookMingguan = LogbookMingguan::find($id);
        return view('pages.aktivitas.logbook.mingguan.edit', [
            'dataLogbookMingguan' => $dataLogbookMingguan,
            'listRegistrasiMbkm' => $listRegistrasiMbkm,
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
        // dd($request);
        $request->validate([
            'registrasi_mbkm_id' => 'required|exists:registrasi_mbkm,id',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'link_dokumen' => 'nullable|file|mimetypes:application/pdf|max:5120', // 5MB
            // 'link_video' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'link_video' => 'nullable|file|mimetypes:image/bmp,image/gif,image/jpeg,image/png|max:5120', // 20MB
            'link_youtube' => 'nullable|string',
            'minggu' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $lb = LogbookMingguan::find($id);

        if (!$lb) {
            return redirect()->back()->with('error', 'logbook mingguan tidak ditemukan');
        }

        $pathDokumen = NULL;
        $pathVideo = NULL;
        if ($request->file('link_dokumen')) {
            $pathDokumen = request()->file('link_dokumen')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $pathVideo = request()->file('link_video')->store('gambar/' . date('Y'), 'public');
        }

        $lb->minggu = $request->minggu;
        $lb->registrasi_mbkm_id = $request->registrasi_mbkm_id;
        if ($pathDokumen) {
            $lb->link_dokumen = $pathDokumen;
        }
        if ($pathVideo) {
            $lb->link_video = $pathVideo;
        }
        $lb->link_youtube = $request->link_youtube;
        $lb->judul = $request->judul;
        $lb->deskripsi = $request->deskripsi;
        $lb->tanggal = $request->tanggal;
        $lb->save();

        return redirect()->back()->with('message', 'logbook mingguan successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogbookMingguan::find($id)->forceDelete();

        return redirect()->back()->with('message', 'logbook mingguan successfully deleted');
    }
}
