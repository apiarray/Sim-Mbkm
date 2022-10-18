<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Dao\Masters\SemesterDao;
use App\Dao\Masters\TahunAjaranDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\TahunAjaranRequest;

class TahunAjaranController extends Controller
{
    private TahunAjaranDao $tahunAjaranDao;
    private SemesterDao $semesterDao;

    public function __construct(TahunAjaranDao $tahunAjaranDao, SemesterDao $semesterDao)
    {
        $this->tahunAjaranDao = $tahunAjaranDao;
        $this->semesterDao = $semesterDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahunAjaranList = $this->tahunAjaranDao->getPaginate();
        return view('pages.masters.tahun-ajaran.index', [
            'tahunAjaranList' => $tahunAjaranList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $semesterList = $this->semesterDao->getAll();
        return view('pages.masters.tahun-ajaran.create', [
            'semesterList' => $semesterList->data
        ]);
    }

    /**
     * Update the status of the item of Tahun Ajaran.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $updateStatus = $this->tahunAjaranDao->updateStatus($id);
        return redirect()->back()->with($updateStatus->isOk ? 'message' : 'error', $updateStatus->message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TahunAjaranRequest $request)
    {
        $validated = $request->validated();
        $insertTahunAjaran = $this->tahunAjaranDao->insert($validated);

        if ($insertTahunAjaran->isOk) {
            return redirect()->back()->with('message', $insertTahunAjaran->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertTahunAjaran->message);
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
        $tahunAjaran = $this->tahunAjaranDao->getById($id);
        $semesterList = $this->semesterDao->getAll();
        return view('pages.masters.tahun-ajaran.edit', [
            'tahunAjaran' => $tahunAjaran->data,
            'semesterList' => $semesterList->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TahunAjaranRequest $request, $id)
    {
        $validated = $request->validated();
        $updateTahunAjaran = $this->tahunAjaranDao->update($id, $validated);

        if ($updateTahunAjaran->isOk) {
            return redirect()->back()->with('message', $updateTahunAjaran->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateTahunAjaran->message);
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
        $deleteTahunAjaran = $this->tahunAjaranDao->delete($id);
        return redirect()->back()->with($deleteTahunAjaran->isOk ? 'message' : 'error', $deleteTahunAjaran->message);
    }
}
