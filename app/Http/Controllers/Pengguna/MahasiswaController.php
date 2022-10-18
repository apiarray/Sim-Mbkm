<?php

namespace App\Http\Controllers\Pengguna;

use App\Dao\KotaKabupatenDao;
use App\Dao\Masters\KelasDao;
use App\Dao\Masters\TahunAjaranDao;
use App\Dao\Pengguna\MahasiswaDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengguna\MahasiswaRequest;
use App\Imports\Pengguna\MahasiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    private $mahasiswaDao, $kelasDao, $tahunAjaranDao, $kotaKabupatenDao;

    public function __construct(MahasiswaDao $mahasiswaDao, KelasDao $kelasDao, TahunAjaranDao $tahunAjaranDao, KotaKabupatenDao $kotaKabupatenDao)
    {
        $this->mahasiswaDao = $mahasiswaDao;
        $this->kelasDao = $kelasDao;
        $this->tahunAjaranDao = $tahunAjaranDao;
        $this->kotaKabupatenDao = $kotaKabupatenDao;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataMahasiswaList = $this->mahasiswaDao->getPaginate();
        return view('pages.pengguna.mahasiswa.index', [
            'dataMahasiswaList' => $dataMahasiswaList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kotaList = $this->kotaKabupatenDao->getAll();
        $tahunMasukList = [];
        for($i = (date('Y') -3); $i <= (date('Y') +5); $i++){
            $tahunMasukList[] = [
                'id' => $i,
                'nama' => $i,
            ];
        }
        $statusList = [
            [
                'id' => 'internal',
                'nama' => 'Internal'
            ],
            [
                'id' => 'luar_unidha',
                'nama' => 'Luar UNIDHA'
            ],
        ];
        $jenisKelaminList = [
            [
                'id' => 'pria',
                'nama' => 'Pria'
            ],
            [
                'id' => 'wanita',
                'nama' => 'Wanita'
            ],
        ];
        $jenisPendaftaran = [
            [
                'id' => 'baru',
                'nama' => 'Pendaftaran Baru'
            ],
            [
                'id' => 'pindahan',
                'nama' => 'Pindahan'
            ],
        ];
        return view('pages.pengguna.mahasiswa.create', [
            'tahunMasukList' => $tahunMasukList,
            'statusList' => $statusList,
            'jenisKelaminList' => $jenisKelaminList,
            'jenisPendaftaran' => $jenisPendaftaran,
            'kotaList' => $kotaList->data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MahasiswaRequest $request)
    {
        $validated = $request->validated();
        $insert = $this->mahasiswaDao->insert($validated);

        if ($insert->isOk) {
            return redirect()->back()->with('message', $insert->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insert->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataMahasiswa = $this->mahasiswaDao->getById($id);

        return view('pages.pengguna.mahasiswa.detail', [
            'dataMahasiswa' => $dataMahasiswa->data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataMahasiswa = $this->mahasiswaDao->getById($id);
        $kotaList = $this->kotaKabupatenDao->getAll();
        $tahunMasukList = [];
        for($i = (date('Y') -3); $i <= (date('Y') +5); $i++){
            $tahunMasukList[] = [
                'id' => $i,
                'nama' => $i,
            ];
        }
        $statusList = [
            [
                'id' => 'internal',
                'nama' => 'Internal'
            ],
            [
                'id' => 'luar_unidha',
                'nama' => 'Luar UNIDHA'
            ],
        ];
        $jenisKelaminList = [
            [
                'id' => 'pria',
                'nama' => 'Pria'
            ],
            [
                'id' => 'wanita',
                'nama' => 'Wanita'
            ],
        ];
        $jenisPendaftaran = [
            [
                'id' => 'baru',
                'nama' => 'Pendaftaran Baru'
            ],
            [
                'id' => 'pindahan',
                'nama' => 'Pindahan'
            ],
        ];
        return view('pages.pengguna.mahasiswa.edit', [
            'dataMahasiswa' => $dataMahasiswa->data,
            'tahunMasukList' => $tahunMasukList,
            'statusList' => $statusList,
            'jenisKelaminList' => $jenisKelaminList,
            'jenisPendaftaran' => $jenisPendaftaran,
            'kotaList' => $kotaList->data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MahasiswaRequest $request, $id)
    {
        $validated = $request->validated();
        $insert = $this->mahasiswaDao->update($id, $validated);

        if ($insert->isOk) {
            return redirect()->back()->with('message', $insert->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insert->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteMahasiswa = $this->mahasiswaDao->delete($id);
        return redirect()->back()->with($deleteMahasiswa->isOk ? 'message' : 'error', $deleteMahasiswa->message);
    }

    public function uploadView(Request $request)
    {
        return view('pages.pengguna.mahasiswa.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        Excel::import(new MahasiswaImport, $request->file);

        return redirect()->route('pengguna.mahasiswa.index')->with('message', 'User Imported Successfully');
    }
}
