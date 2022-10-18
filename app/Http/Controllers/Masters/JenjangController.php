<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;

use App\Dao\Masters\JenjangDao;
use App\Http\Requests\Masters\JenjangRequest;

class JenjangController extends Controller
{
    private JenjangDao $jenjangDao;

    public function __construct(JenjangDao $jenjangDao)
    {
        $this->jenjangDao = $jenjangDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenjangData = $this->jenjangDao->getPaginate();
        return view('pages.masters.jenjang.index', [
            'jenjang' => $jenjangData->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masters.jenjang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenjangRequest $request)
    {
        $validated = $request->validated();
        $insertJenjang = $this->jenjangDao->insert($validated);

        if ($insertJenjang->isOk) {
            return redirect()->back()->with('message', $insertJenjang->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertJenjang->message);
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
        $jenjangData = $this->jenjangDao->getById($id);
        return view('pages.masters.jenjang.edit', [
            'jenjang' => $jenjangData->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JenjangRequest $request, $id)
    {
        $validated = $request->validated();
        $updateJenjang = $this->jenjangDao->update($id, $validated);

        if ($updateJenjang->isOk) {
            return redirect()->back()->with('message', $updateJenjang->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateJenjang->message);
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
        $deleteJenjang = $this->jenjangDao->delete($id);

        if ($deleteJenjang->isOk) {
            request()->session()->flash('message', $deleteJenjang->message);
        } else {
            request()->session()->flash('error', $deleteJenjang->message);
        }
        return redirect()->back();
    }
}
