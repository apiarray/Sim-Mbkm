<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\BabPenilaianDao;
use App\Dao\Masters\PenilaianDao;
use App\Dao\Masters\PilihanPenilaianDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\PenilaianRequest;
use App\Models\Master\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    private PenilaianDao $penilaianDao;
    private BabPenilaianDao $babPenilaianDao;
    private PilihanPenilaianDao $pilihanPenilaianDao;

    public function __construct(PenilaianDao $penilaianDao, BabPenilaianDao $babPenilaianDao, PilihanPenilaianDao $pilihanPenilaianDao)
    {
        $this->penilaianDao = $penilaianDao;
        $this->babPenilaianDao = $babPenilaianDao;
        $this->pilihanPenilaianDao = $pilihanPenilaianDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaianList = $this->penilaianDao->getPaginate();

        return view('pages.masters.penilaian.index', [
            'penilaianList' => $penilaianList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $babPenilaianList = $this->babPenilaianDao->getAll();

        return view('pages.masters.penilaian.create', [
            'babPenilaianList' => $babPenilaianList->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PenilaianRequest $request)
    {
        $validated = $request->validated();
        $insert = $this->penilaianDao->insert($validated);

        if ($insert->isOk) {
            return redirect()->back()->with('message', $insert->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insert->message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penilaian = $this->penilaianDao->getById($id);
        $pilihanPenilaianList = $this->pilihanPenilaianDao->getByParentId($id, 'penilaian_id');
        // dd($penilaian, $pilihanPenilaianList);
        return view('pages.masters.penilaian.show', [
            'penilaian' => $penilaian->data,
            'pilihanPenilaianList' => $pilihanPenilaianList->data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penilaian = $this->penilaianDao->getById($id);
        $babPenilaianList = $this->babPenilaianDao->getAll();
        return view('pages.masters.penilaian.edit', [
            'penilaian' => $penilaian->data,
            'babPenilaianList' => $babPenilaianList->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PenilaianRequest $request, $id)
    {
        $validated = $request->validated();
        $update = $this->penilaianDao->update($id, $validated);

        if ($update->isOk) {
            return redirect()->back()->with('message', $update->message);
        } else {
            return redirect()->back()->withInput()->with('error', $update->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->penilaianDao->delete($id);
        return redirect()->back()->with($delete->isOk ? 'message' : 'error', $delete->message);
    }
}
