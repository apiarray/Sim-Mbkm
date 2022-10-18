<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Schedules;
use App\Models\Todolist;
use App\Models\Notes;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->guard('mahasiswa')->check()){			
			return $this->index_mhs();
            //return 'Halaman Dashboard Mahasiswa. On Progress. <a href="'. url('/logoutm') .'">LOGOUT</a>';
        } else if(auth()->guard('dosen')->check()){
			return $this->index_dos();
            //return 'Halaman Dashboard Dosen. On Progress. <a href="'. url('/logoutd') .'">LOGOUT</a>';
        } else if(auth()->guard('admin')->check()){
            return view('pages.dashboard.index');
        }
    }
	
	public function index_dos()
    {
        // dd(auth()->guard('dosen'));
        return view('pages.dashboard.index_dos');
    }
	public function index_mhs()
    {	
		
        // dd(auth()->guard('dosen'));
        return view('pages.dashboard.index_mhs');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
