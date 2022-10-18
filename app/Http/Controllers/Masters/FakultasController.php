<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\FakultasDao;
use App\Dao\Masters\JenjangDao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\FakultasRequest;

use Illuminate\Http\Request;

class FakultasController extends Controller
{
    private FakultasDao $fakultasDao;

    private JenjangDao $jenjangDao;

    public function __construct(FakultasDao $fakultasDao, JenjangDao $jenjangDao)
    {
        $this->fakultasDao = $fakultasDao;
        $this->jenjangDao = $jenjangDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $fakultasData = $this->fakultasDao->getPaginate();
        return view('pages.masters.fakultas.index', [
            'fakultas' => $fakultasData->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenjangList = $this->jenjangDao->getAll();

        return view('pages.masters.fakultas.create', [
            'jenjangList' => $jenjangList->data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FakultasRequest $request)
    {
        $validated = $request->validated();
        $insertFakultas = $this->fakultasDao->insert($validated);

        if ($insertFakultas->isOk) {
            $request->session()->flash('message', $insertFakultas->message);
            return redirect()->back();
        } else {
            $request->session()->flash('error', $insertFakultas->message);
            return redirect()->back()->withInput();
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
        $jenjangList = $this->jenjangDao->getAll();
        $fakultasData = $this->fakultasDao->getById($id);

        return view('pages.masters.fakultas.edit', [
            'jenjangList' => $jenjangList->data,
            'fakultas' => $fakultasData->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FakultasRequest $request, $id)
    {
        $validated = $request->validated();
        $updateFakultas = $this->fakultasDao->update($id, $validated);

        if ($updateFakultas->isOk) {
            return redirect()->back()->with('message', $updateFakultas->message);
        } else {
            //$request->session()->flash('error', $updateFakultas->message);
            return redirect()->back()->withInput();
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
        $deleteFakultas = $this->fakultasDao->delete($id);

        if ($deleteFakultas->isOk) {
            request()->session()->flash('message', $deleteFakultas->message);
        } else {
            request()->session()->flash('error', $deleteFakultas->message);
        }

        return redirect()->back();
    }
}
