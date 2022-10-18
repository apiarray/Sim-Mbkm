<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\BabPenilaianDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\BabPenilaianRequest;
use App\Models\Master\Penilaian;
use Illuminate\Http\Request;

class BabPenilaianController extends Controller
{
    public function __construct(BabPenilaianDao $babPenilaianDao)
    {
        $this->babPenilaianDao = $babPenilaianDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $babPenilaianList = $this->babPenilaianDao->getPaginate();
        return view('pages.masters.bab-penilaian.index', [
            'babPenilaianList' => $babPenilaianList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masters.bab-penilaian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BabPenilaianRequest $request)
    {
        $validated = $request->validated();
        $insert = $this->babPenilaianDao->insert($validated);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $babPenilaian = $this->babPenilaianDao->getById($id);
        return view('pages.masters.bab-penilaian.edit', [
            'babPenilaian' => $babPenilaian->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BabPenilaianRequest $request, $id)
    {
        $validated = $request->validated();
        $update = $this->babPenilaianDao->update($id, $validated);

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
        $delete = $this->babPenilaianDao->delete($id);
        return redirect()->back()->with($delete->isOk ? 'message' : 'error', $delete->message);
    }
}
