<?php

namespace App\Http\Controllers\Aktivitas;

use App\Dao\Aktivitas\RegistrasiMbkmDao;
use App\Dao\Masters\KelasDao;
use App\Dao\Pengguna\DosenDplDao;
use App\Dao\Pengguna\RegistrasiDao;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\Masters\Program;
use App\Models\Masters\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RegistrasiMbkmController extends Controller
{
    private $registrasiMbkmDao, $dosenDplDao, $kelasDao;

    public function __construct(RegistrasiMbkmDao $registrasiMbkmDao, DosenDplDao $dosenDplDao, KelasDao $kelasDao)
    {
        $this->registrasiMbkmDao = $registrasiMbkmDao;
        $this->dosenDplDao = $dosenDplDao;
        $this->kelasDao = $kelasDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listTahunAjaran = TahunAjaran::getListTahunAjaran();
        $listProgram = Program::select('id', 'nama')->get();
        $dataDosenDpl = $this->dosenDplDao->getAll();
        $dataKelas = $this->kelasDao->getAll();
        return view('pages.aktivitas.registrasi-mbkm.index', [
            'dataDosenDpl' => $dataDosenDpl->data,
            'dataKelas' => $dataKelas->data,
            'listTahunAjaran' => $listTahunAjaran,
            'listProgram' => $listProgram,
        ]);
    }

    public function listRegistrasiDatatable(Request $request)
    {
        $data = RegistrasiMbkm::listRegistrasi(1);

        if ($request->tahun_ajaran_id) {
            $data = $data->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        if ($request->status_validasi) {
            $data = $data->where('status_validasi', $request->status_validasi);
        }

        if ($request->program_id) {
            $data = $data->where('program_id', $request->program_id);
        }

        if ($request->is_accepted) {
            $data = $data->where('is_accepted', $request->is_accepted);
        }

        if (auth()->guard('mahasiswa')->check()) {
            $data = $data->where('registrasi_mbkm.mahasiswa_id', auth()->guard('mahasiswa')->user()->id);
        }

        if (auth()->guard('dosen')->check()) {
            $data = $data->where('registrasi_mbkm.dosen_dpl_id', auth()->guard('dosen')->user()->id);
            $data = $data->where('registrasi_mbkm.status_validasi', 'tervalidasi');
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->filterColumn('ttanggal_registrasi', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(registrasi_mbkm.tanggal_registrasi,'%d-%m-%Y') like ?", ["%{$keyword}%"]);
            })
            ->filterColumn('ttanggal_validasi', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(registrasi_mbkm.tanggal_validasi,'%d-%m-%Y') like ?", ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($row) {
                return json_encode($row);
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function listRegistrasiAll(Request $request)
    {
        $data = RegistrasiMbkm::listRegistrasi(1);
        $data = $data->addSelect(DB::raw("(SELECT id_penilaian from penilaian_dosen_dpl where penilaian_dosen_dpl.registrasi_mbkm_id = registrasi_mbkm.id order by penilaian_dosen_dpl.tanggal_penilaian DESC Limit 1) as id_penilaian"));
        $data = $data->addSelect(DB::raw("(SELECT tanggal_penilaian from penilaian_dosen_dpl where penilaian_dosen_dpl.registrasi_mbkm_id = registrasi_mbkm.id order by penilaian_dosen_dpl.tanggal_penilaian and penilaian_dosen_dpl.status = 'tervalidasi' DESC Limit 1) as tanggal_penilaian"));
        $data = $data->addSelect(DB::raw("(SELECT count(*) from logbook_harian where logbook_harian.registrasi_mbkm_id = registrasi_mbkm.id and logbook_harian.status = 'tervalidasi') as count_logbook_harian"));
        $data = $data->addSelect(DB::raw("(SELECT count(*) from logbook_mingguan where logbook_mingguan.registrasi_mbkm_id = registrasi_mbkm.id and logbook_mingguan.status = 'tervalidasi') as count_logbook_mingguan"));
        $data = $data->addSelect(DB::raw("(SELECT id_laporan_akhir_mahasiswa from laporan_akhir_mahasiswa where laporan_akhir_mahasiswa.registrasi_mbkm_id = registrasi_mbkm.id order by laporan_akhir_mahasiswa.tanggal_laporan_akhir and laporan_akhir_mahasiswa.status_laporan_akhir = 'validasi' DESC Limit 1) as id_laporan_akhir_mahasiswa"));

        if ($request->tahun_ajaran_id) {
            $data = $data->where('registrasi_mbkm.tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->dosen_dpl_id) {
            $data = $data->where('registrasi_mbkm.dosen_dpl_id', $request->dosen_dpl_id);
        }
        if ($request->status_validasi) {
            $data = $data->where('status_validasi', $request->status_validasi);
        }
        if ($request->program_id) {
            $data = $data->where('program_id', $request->program_id);
        }
        if ($request->is_accepted) {
            $data = $data->where('is_accepted', $request->is_accepted);
        }
        if ($request->has_penilaian) {
            $data = $data->whereRaw('((SELECT id_penilaian from penilaian_dosen_dpl where penilaian_dosen_dpl.registrasi_mbkm_id = registrasi_mbkm.id order by penilaian_dosen_dpl.tanggal_penilaian DESC Limit 1) is not null)');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $dataRegistrasi = $this->registrasiMbkmDao->getById($id);

        if ($request->ajax()) {
            return $dataRegistrasi;
        } else {
            return 'Oppss';
        }
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataRegistrasi = $this->registrasiMbkmDao->getById($id);

        if ($dataRegistrasi->data->status_validasi == 'mengajukan') {
            $deleteRegistrasi = $this->registrasiMbkmDao->delete($id);
            return redirect()->back()->with($deleteRegistrasi->isOk ? 'message' : 'error', $deleteRegistrasi->message);
        } else {
            return redirect()->back()->withInput()->with('error', 'Registrasi tidak dapat dihapus');
        }
    }

    public function validasiRegistrasi(Request $request, $id)
    {
        $dataRegistrasi = $this->registrasiMbkmDao->getById($id);

        if ($dataRegistrasi->data->status_validasi == 'mengajukan') {
            $request->validate([
                'dosen_dpl_id' => 'required|exists:dosen_dpl,id',
                'kelas_id' => 'required|exists:kelas,id'
            ]);
            $now = now();
            $dataUpdate = [
                'id_registrasi' => generateRandomString(10, 4),
                'tanggal_validasi' => $now,
                'status_validasi' => 'tervalidasi',
                'dosen_dpl_id' => $request->dosen_dpl_id,
                'kelas_id' => $request->kelas_id,
            ];

            $updateValidasi = $this->registrasiMbkmDao->update($id, $dataUpdate);
            if ($updateValidasi->isOk) {
                return redirect()->back()->with('message', $updateValidasi->message);
            } else {
                return redirect()->back()->withInput()->with('error', $updateValidasi->message);
            }
        } else if ($dataRegistrasi->data->status_validasi == 'tervalidasi') {
            $dataUpdate = [
                'id_registrasi' => NULL,
                'tanggal_validasi' => NULL,
                'status_validasi' => 'batal',
                'dosen_dpl_id' => NULL
            ];

            $updateValidasi = $this->registrasiMbkmDao->update($id, $dataUpdate);
            if ($updateValidasi->isOk) {
                return redirect()->back()->with('message', $updateValidasi->message);
            } else {
                return redirect()->back()->withInput()->with('error', $updateValidasi->message);
            }
        } else if ($dataRegistrasi->data->status_validasi == 'batal') {
            $dataUpdate = [
                'id_registrasi' => NULL,
                'tanggal_validasi' => NULL,
                'status_validasi' => 'mengajukan',
                'dosen_dpl_id' => NULL
            ];

            $updateValidasi = $this->registrasiMbkmDao->update($id, $dataUpdate);
            if ($updateValidasi->isOk) {
                return redirect()->back()->with('message', $updateValidasi->message);
            } else {
                return redirect()->back()->withInput()->with('error', $updateValidasi->message);
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Registrasi tidak dapat divalidasi');
        }
    }

    public function acceptRejectRegistrasi(Request $request, $id)
    {
        $dataRegistrasi = $this->registrasiMbkmDao->getById($id);
        if ($dataRegistrasi->isOk) {
            $oldIsAccepted = $dataRegistrasi->data->is_accepted;
            $dataUpdate = [
                'is_accepted' => $oldIsAccepted == 1 ? 0 : 1
            ];
            $updateValidasi = $this->registrasiMbkmDao->update($id, $dataUpdate);
            if ($updateValidasi->isOk) {
                return redirect()->back()->with('message', $updateValidasi->message);
            } else {
                return redirect()->back()->withInput()->with('error', $updateValidasi->message);
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Registrasi tidak dapat ditolak/disetujui');
        }
    }

    public function formUploadFile($id)
    {
        $dataRegistrasi = $this->registrasiMbkmDao->getById($id);
        // dd($dataRegistrasi->data->id);
        return view('pages.aktivitas.registrasi-mbkm.upload', ['dataRegistrasi' => $dataRegistrasi]);
    }

    public function storeUploadFile(Request $request)
    {
        $request->validate([
            'file_khs' => 'nullable|file|mimetypes:application/docx,application/pdf|max:5120', // 5MB
            'file_krs' => 'nullable|file|mimetypes:application/docx,application/pdf|max:5120', // 5MB
        ]);

        $id = $request->id_mahasiswa;
        $pathFileKHS = NULL;
        $pathFileKRS = NULL;

        if ($request->file('file_khs')) {
            $pathFileKHS = request()->file('file_khs')->store('dokumen/' . date('Y'), 'public');
        }

        if ($request->file('file_krs')) {
            $pathFileKRS = request()->file('file_krs')->store('dokumen/' . date('Y'), 'public');
        }

        if ($id) {
            $rg = RegistrasiMbkm::find($id);
            if ($pathFileKHS) {
                $rg->file_khs = $pathFileKHS;
            }
            if ($pathFileKRS) {
                $rg->file_krs = $pathFileKRS;
            }
            $rg->save();
        }
        return redirect()->back()->with('message', 'Upload successfully');
    }
}
