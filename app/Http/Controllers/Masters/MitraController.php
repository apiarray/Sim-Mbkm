<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\MitraDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\MitraRequest;

class MitraController extends Controller
{
    private MitraDao $mitraDao;

    public function __construct(MitraDao $mitraDao)
    {
        $this->mitraDao = $mitraDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mitraList = $this->mitraDao->getPaginate();
        return view('pages.masters.mitra.index', [
            'mitraList' => $mitraList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masters.mitra.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MitraRequest $request)
    {
        $validated = $request->validated();
        $insertMitra = $this->mitraDao->insert($validated);

        if ($insertMitra->isOk) {
            return redirect()->back()->with('message', $insertMitra->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertMitra->message);
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
        $mitraData = $this->mitraDao->getById($id);
        return view('pages.masters.mitra.edit', [
            'mitra' => $mitraData->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MitraRequest $request, $id)
    {
        $validated = $request->validated();
        $updateMitra = $this->mitraDao->update($id, $validated);

        if ($updateMitra->isOk) {
            return redirect()->back()->with('message', $updateMitra->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateMitra->message);
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
        $deleteMitra = $this->mitraDao->delete($id);
        return redirect()->back()->with($deleteMitra->isOk ? 'message' : 'error', $deleteMitra->message);
    }
}
