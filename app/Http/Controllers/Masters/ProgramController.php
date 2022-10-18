<?php

namespace App\Http\Controllers\Masters;

use App\Dao\Masters\ProgramDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masters\ProgramRequest;

class ProgramController extends Controller
{
    private ProgramDao $programDao;

    public function __construct(ProgramDao $programDao)
    {
        $this->programDao = $programDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programList = $this->programDao->getPaginate();
        return view('pages.masters.program.index', [
            'programList' => $programList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masters.program.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        $validated = $request->validated();
        $insertProgram = $this->programDao->insert($validated);

        if ($insertProgram->isOk) {
            return redirect()->back()->with('message', $insertProgram->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertProgram->message);
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
        $program = $this->programDao->getById($id);
        return view('pages.masters.program.edit', [
            'program' => $program->data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, $id)
    {
        $validated = $request->validated();
        $updateProgram = $this->programDao->update($id, $validated);

        if ($updateProgram->isOk) {
            return redirect()->back()->with('message', $updateProgram->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateProgram->message);
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
        $deleteProgram = $this->programDao->delete($id);
        return redirect()->back()->with($deleteProgram->isOk ? 'message' : 'error', $deleteProgram->message);
    }
}
