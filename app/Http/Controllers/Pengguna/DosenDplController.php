<?php

namespace App\Http\Controllers\Pengguna;

use App\Dao\Masters\FakultasDao;
use App\Dao\Pengguna\DosenDplDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengguna\DosenDplRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenDplController extends Controller
{
    private $dosenDplDao, $fakultasDao;

    public function __construct(DosenDplDao $dosenDplDao, FakultasDao $fakultasDao)
    {
        $this->dosenDplDao = $dosenDplDao;
        $this->fakultasDao = $fakultasDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataDosenList = $this->dosenDplDao->getPaginate();
        return view('pages.pengguna.dosen-dpl.index', [
            'dataDosenList' => $dataDosenList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fakultasList = $this->fakultasDao->getAll();
        return view('pages.pengguna.dosen-dpl.create', [
            'fakultasList' => $fakultasList->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DosenDplRequest $request)
    {
        $validated = $request->validated();
        $insertDosen = $this->dosenDplDao->insert($validated);

        if ($insertDosen->isOk) {
            return redirect()->back()->with('message', $insertDosen->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertDosen->message);
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
        $dataDosen = $this->dosenDplDao->getById($id);
        return view('pages.pengguna.dosen-dpl.detail', [
            'dataDosen' => $dataDosen->data
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
        $fakultasList = $this->fakultasDao->getAll();
        $dataDosen = $this->dosenDplDao->getById($id);
        return view('pages.pengguna.dosen-dpl.edit', [
            'fakultasList' => $fakultasList->data,
            'dataDosen' => $dataDosen->data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DosenDplRequest $request, $id)
    {
        $validated = $request->validated();
        if(empty($validated['password'])){
            unset($validated['password']);
        }
        $updateDosen = $this->dosenDplDao->update($id, $validated);

        if ($updateDosen->isOk) {
            return redirect()->back()->with('message', $updateDosen->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateDosen->message);
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
        $deleteDosen = $this->dosenDplDao->delete($id);
        return redirect()->back()->with($deleteDosen->isOk ? 'message' : 'error', $deleteDosen->message);
    }
}
