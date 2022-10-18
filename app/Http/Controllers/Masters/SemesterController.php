<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\SemesterDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\SemesterRequest;

class SemesterController extends Controller
{
    private SemesterDao $semesterDao;

    public function __construct(SemesterDao $semesterDao)
    {
        $this->semesterDao = $semesterDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesterList = $this->semesterDao->getPaginate();
        return view('pages.masters.semester.index', [
            'semesterList' => $semesterList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masters.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterRequest $request)
    {
        $validated = $request->validated();
        $insertSemester = $this->semesterDao->insert($validated);

        if ($insertSemester->isOk) {
            return redirect()->back()->with('message', $insertSemester->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertSemester->message);
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
        $semester = $this->semesterDao->getById($id);
        return view('pages.masters.semester.edit', [
            'semester' => $semester->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SemesterRequest $request, $id)
    {
        $validated = $request->validated();
        $insertSemester = $this->semesterDao->update($id, $validated);

        if ($insertSemester->isOk) {
            return redirect()->back()->with('message', $insertSemester->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertSemester->message);
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
        $deleteSemester = $this->semesterDao->delete($id);
        return redirect()->back()->with($deleteSemester->isOk ? 'message' : 'error', $deleteSemester->message);
    }
}
