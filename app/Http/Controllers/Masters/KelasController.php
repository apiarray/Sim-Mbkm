<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\JurusanDao;
use App\Dao\Masters\KelasDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\KelasRequest;

class KelasController extends Controller
{
    private KelasDao $kelasDao;
    private JurusanDao $jurusanDao;

    public function __construct(JurusanDao $jurusanDao, KelasDao $kelasDao)
    {
        $this->jurusanDao = $jurusanDao;
        $this->kelasDao = $kelasDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelasList = $this->kelasDao->getPaginate();
        return view('pages.masters.kelas.index', [
            'kelasList' => $kelasList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jurusanList = $this->jurusanDao->getAll();
        return view('pages.masters.kelas.create', [
            'jurusanList' => $jurusanList->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KelasRequest $request)
    {
        $validated = $request->validated();
        $insertKelas = $this->kelasDao->insert($validated);

        if ($insertKelas->isOk) {
            return redirect()->back()->with('message', $insertKelas->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertKelas->message);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jurusanList = $this->jurusanDao->getAll();
        $kelasData = $this->kelasDao->getById($id);

        return view('pages.masters.kelas.edit', [
            'jurusanList' => $jurusanList->data,
            'kelas' => $kelasData->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KelasRequest $request, $id)
    {
        $validated = $request->validated();
        $updateKelas = $this->kelasDao->update($id, $validated);

        if ($updateKelas->isOk) {
            return redirect()->back()->with('message', $updateKelas->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateKelas->message);
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
        $delete = $this->kelasDao->delete($id);
        return redirect()->back()->with($delete->isOk ? 'message' : 'error', $delete->message);
    }
}
