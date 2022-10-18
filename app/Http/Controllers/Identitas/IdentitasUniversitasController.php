<?php

namespace App\Http\Controllers\Identitas;

use App\Http\Controllers\Controller;

use App\Dao\Identitas\IdentitasUniversitasDao;
use App\Http\Requests\IdentitasUniversitasRequest;

class IdentitasUniversitasController extends Controller
{
    private IdentitasUniversitasDao $identitasUniversitasDao;

    public function __construct(IdentitasUniversitasDao $identitasUniversitasDao)
    {
        $this->identitasUniversitasDao = $identitasUniversitasDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $identitas = $this->identitasUniversitasDao->getPaginate();
        return view('pages.identitas-universitas.index', [
            'identitas' => $identitas->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.identitas-universitas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IdentitasUniversitasRequest $request)
    {
        $validated = $request->validated();
        $insertIdentitas = $this->identitasUniversitasDao->insert($validated);

        if ($insertIdentitas->isOk) {
            $request->session()->flash('message', $insertIdentitas->message);
            return redirect()->back();
        } else {
            $request->session()->flash('error', $insertIdentitas->message);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $identitas = $this->identitasUniversitasDao->getById($id);
        return view('pages.identitas-universitas.edit', [
            'identitas' => $identitas->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IdentitasUniversitasRequest $request, $id)
    {
        $validated = $request->validated();
        $updateIdentitas = $this->identitasUniversitasDao->update($id, $validated);

        if ($updateIdentitas->isOk) {
            $request->session()->flash('message', $updateIdentitas->message);
            return redirect()->back();
        } else {
            $request->session()->flash('error', $updateIdentitas->message);
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
        $deleteIdentitas = $this->identitasUniversitasDao->delete($id);

        if ($deleteIdentitas->isOk) {
            request()->session()->flash('message', $deleteIdentitas->message);
        } else {
            request()->session()->flash('error', $deleteIdentitas->message);
        }
        return redirect()->back();
    }
}
