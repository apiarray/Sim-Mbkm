<?php

namespace App\Http\Controllers\Pengguna;

use App\Dao\Pengguna\AdminDao;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pengguna\AdminRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(AdminDao $adminDao)
    {
        $this->adminDao = $adminDao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataAdminList = $this->adminDao->getPaginate();
        return view('pages.pengguna.admin.index', [
            'dataAdminList' => $dataAdminList->data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pengguna.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $validated = $request->validated();
        $insertAdmin = $this->adminDao->insert($validated);

        if ($insertAdmin->isOk) {
            return redirect()->back()->with('message', $insertAdmin->message);
        } else {
            return redirect()->back()->withInput()->with('error', $insertAdmin->message);
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
        $adminData = $this->adminDao->getById($id);
        return view('pages.pengguna.admin.edit', [
            'adminData' => $adminData->data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, $id)
    {
        $validated = $request->validated();
        $updateAdmin = $this->adminDao->update($id, $validated);

        if ($updateAdmin->isOk) {
            return redirect()->back()->with('message', $updateAdmin->message);
        } else {
            return redirect()->back()->withInput()->with('error', $updateAdmin->message);
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
        $deleteAdmin = $this->adminDao->delete($id);
        return redirect()->back()->with($deleteAdmin->isOk ? 'message' : 'error', $deleteAdmin->message);
    }
}
