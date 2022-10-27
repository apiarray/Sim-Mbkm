<?php

namespace App\Http\Controllers\Aktivitas;

use App\Dao\Aktivitas\LogbookHarianDao;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\LogbookHarian;
use App\Models\Aktivitas\RegistrasiMbkm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogBookHarianController extends Controller
{
    private $logbookHarianDao, $fakultasDao;

    public function __construct(LogbookHarianDao $logbookHarianDao)
    {
        $this->logbookHarianDao = $logbookHarianDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.aktivitas.logbook.harian.index');
    }

    public function listLogHarianDatatable(Request $request)
    {
        $data = LogbookHarian::listLogbookharian(1);

        return DataTables::of($data)
            ->addIndexColumn()
            ->filterColumn('ttanggal', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(logbook_harian.tanggal,'%d-%m-%Y') like ?", ["%{$keyword}%"]);
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
            ->get();
        return view('pages.aktivitas.logbook.harian.create', [
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
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'link_dokumen' => 'nullable|file|mimetypes:application/pdf|max:5120', // 5MB
            // 'link_video' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'link_video' => 'nullable|file|mimetypes:image/bmp,image/gif,image/jpeg,image/png|max:5120', // 5MB
            'tanggal' => 'required|date',
            'durasi' => 'required|in:6,8',
        ]);

        $pathDokumen = NULL;
        $pathVideo = NULL;
        if ($request->file('link_dokumen')) {
            $pathDokumen = request()->file('link_dokumen')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $pathVideo = request()->file('link_video')->store('gambar/' . date('Y'), 'public');
        }

        $lb = new LogbookHarian;
        $lb->tanggal = $request->tanggal;
        $lb->registrasi_mbkm_id = $request->registrasi_mbkm_id;
        if ($pathDokumen) {
            $lb->link_dokumen = $pathDokumen;
        }
        if ($pathVideo) {
            $lb->link_video = $pathVideo;
        }
        $lb->judul = $request->judul;
        $lb->deskripsi = $request->deskripsi;
        $lb->durasi = $request->durasi;
        $lb->status = 'mengajukan';
        $lb->save();

        return redirect()->back()->with('message', 'logbook harian successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataLogbookHarian = LogbookHarian::find($id);
        return view('pages.aktivitas.logbook.harian.show', [
            'dataLogbookHarian' => $dataLogbookHarian
        ]);
    }

    public function validateLogbook(Request $request, $id)
    {
        $dataLogbookHarian = LogbookHarian::find($id);
        if (!$dataLogbookHarian) {
            return redirect()->back()->with('message', 'logbook harian tidak ditemukan');
        }

        $request->validate([
            'status' => 'required|in:mengajukan,dalam_proses,revisi,tervalidasi'
        ]);

        if ($request->status == 'tervalidasi') {
            $dataLogbookHarian->id_log_harian = generateRandomString(10, 4);
        } else if ($request->status == 'mengajukan') {
            $dataLogbookHarian->id_log_harian = NULL;
        } else if ($request->status == 'dalam_proses') {
            $dataLogbookHarian->id_log_harian = NULL;
        } else if ($request->status == 'revisi') {
            $dataLogbookHarian->id_log_harian = NULL;
        }

        $dataLogbookHarian->status = $request->status;
        $dataLogbookHarian->save();

        return redirect()->back()->with('message', 'logbook harian successfully submited');
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
        $dataLogbookHarian = LogbookHarian::find($id);
        return view('pages.aktivitas.logbook.harian.edit', [
            'dataLogbookHarian' => $dataLogbookHarian,
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
        $request->validate([
            'registrasi_mbkm_id' => 'required|exists:registrasi_mbkm,id',
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'link_dokumen' => 'nullable|file|mimetypes:application/pdf|max:5120', // 5MB
            // 'link_video' => 'nullable|file|mimetypes:video/mp4,video/mpeg|max:20480', // 20MB
            'link_video' => 'nullable|file|mimetypes:image/bmp,image/gif,image/jpeg,image/png|max:5120', // 5MB
            'tanggal' => 'required|date',
            'durasi' => 'required|in:6,8',
        ]);

        $lb = LogbookHarian::find($id);

        if (!$lb) {
            return redirect()->back()->with('error', 'logbook harian tidak ditemukan');
        }

        $pathDokumen = NULL;
        $pathVideo = NULL;
        if ($request->file('link_dokumen')) {
            $pathDokumen = request()->file('link_dokumen')->store('dokumen/' . date('Y'), 'public');
        }
        if ($request->file('link_video')) {
            $pathVideo = request()->file('link_video')->store('gambar/' . date('Y'), 'public');
        }

        $lb->tanggal = $request->tanggal;
        $lb->registrasi_mbkm_id = $request->registrasi_mbkm_id;
        if ($pathDokumen) {
            $lb->link_dokumen = $pathDokumen;
        }
        if ($pathVideo) {
            $lb->link_video = $pathVideo;
        }
        $lb->judul = $request->judul;
        $lb->deskripsi = $request->deskripsi;
        $lb->durasi = $request->durasi;
        $lb->save();

        return redirect()->back()->with('message', 'logbook harian successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteLogbook = $this->logbookHarianDao->delete($id);

        return redirect()->back()->with($deleteLogbook->isOk ? 'message' : 'error', $deleteLogbook->message);
    }
}
