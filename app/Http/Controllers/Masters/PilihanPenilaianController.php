<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\PenilaianDao;
use App\Dao\Masters\PilihanPenilaianDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\PilihanPenilaianRequest;
use App\Models\Masters\PilihanPenilaian;
use Illuminate\Http\Request;

class PilihanPenilaianController extends Controller
{
    private PenilaianDao $penilaianDao;
    private PilihanPenilaianDao $pilihanPenilaianDao;

    public function __construct(PenilaianDao $penilaianDao, PilihanPenilaianDao $pilihanPenilaianDao)
    {
        $this->penilaianDao = $penilaianDao;
        $this->pilihanPenilaianDao = $pilihanPenilaianDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penilaian = $this->penilaianDao->getById($id);

        return view('pages.masters.pilihan-penilaian.create', [
            'penilaian' => $penilaian->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idPenilaian
     * @return \Illuminate\Http\Response
     */
    public function store(PilihanPenilaianRequest $request, $id)    
    {
        $validated = $request->validated();
        $insert = $this->pilihanPenilaianDao->insert($validated);

        if ($insert->isOk) {
            return redirect()->back()->with('message', $insert->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insert->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $idPenilaian
     * @param  int $idPilihanPenilaian
     * @return \Illuminate\Http\Response
     */
    public function show(PilihanPenilaian $pilihanPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $idPenilaian
     * @param  int $idPilihanPenilaian
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $idPilihan)
    {
        $penilaian = $this->penilaianDao->getById($id);
        $pilihanPenilaian = $this->pilihanPenilaianDao->getById($idPilihan);

        return view('pages.masters.pilihan-penilaian.edit', [
            'penilaian' => $penilaian->data,
            'pilihanPenilaian' => $pilihanPenilaian->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $idPenilaian
     * @param  int $idPilihanPenilaian
     * @return \Illuminate\Http\Response
     */
    public function update(PilihanPenilaianRequest $request, $id, $idPilihan)
    {
        $validated = $request->validated();
        $insert = $this->pilihanPenilaianDao->update($idPilihan, $validated);

        if ($insert->isOk) {
            return redirect()->back()->with('message', $insert->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insert->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $idPenilaian
     * @param  int $idPilihanPenilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $idPilihan)
    {
        $delete = $this->pilihanPenilaianDao->delete($idPilihan);
        return redirect()->back()->with($delete->isOk ? 'message' : 'error', $delete->message);
    }
}
