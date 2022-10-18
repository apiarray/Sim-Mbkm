<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\FakultasDao;
use App\Dao\Masters\JurusanDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\JurusanRequest;
use App\Traits\Response;

class JurusanController extends Controller
{
    use Response;

    private JurusanDao $jurusanDao;
    private FakultasDao $fakultasDao;

    public function __construct(JurusanDao $jurusanDao, FakultasDao $fakultasDao)
    {
        $this->jurusanDao = $jurusanDao;
        $this->fakultasDao = $fakultasDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusanData = $this->jurusanDao->getPaginate();
        return view('pages.masters.jurusan.index', [
            'jurusan' => $jurusanData->data
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
        return view('pages.masters.jurusan.create', [
            'fakultasList' => $fakultasList->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JurusanRequest $request)
    {
        $insertJurusan = $this->jurusanDao->insert($request->validated());

        if ($insertJurusan->isOk) {
            return redirect()->back()->with('message', $insertJurusan->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertJurusan->message);
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
        $fakultasList = $this->fakultasDao->getAll();
        $jurusanData = $this->jurusanDao->getById($id);

        return view('pages.masters.jurusan.edit', [
            'jurusan' => $jurusanData->data,
            'fakultasList' => $fakultasList->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JurusanRequest $request, $id)
    {
        $updateJurusan = $this->jurusanDao->update($id, $request->validated());

        if ($updateJurusan->isOk) {
            return redirect()->back()->with('message', $updateJurusan->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateJurusan->message);
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
        $deleteJurusan = $this->jurusanDao->delete($id);

        if ($deleteJurusan->isOk) {
            request()->session()->flash('message', $deleteJurusan->message);
        } else {
            request()->session()->flash('error', $deleteJurusan->message);
        }
        return back();
    }
}
