<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\Subscribed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Facades\Mail;
use Illuminate\Http\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Pengguna\RegistrasiRequest;

use App\Dao\Pengguna\RegistrasiDao;
use App\Models\Aktivitas\RegistrasiMbkm;

use App\Dao\KontenlandingDao;
use App\Http\Requests\Masters\KontenRequest;
//use App\Models\RegistrasiMbkm;
//use App\Models\RegistrasiMbkm;

class LandingPageController extends Controller
{
    //
	public function __construct(RegistrasiDao $RegistrasiDao)
    {
        $this->RegistrasiDao = $RegistrasiDao;
    }
	
	public function index()
    {
       // return view('landing');
	   
		$sambutan = DB::table('konten-landings')->where('jenis', 'sambutan')->where('aktif', 1)->orderBy('tanggal', 'desc')->get();;
		$download = DB::table('konten-landings')->where('jenis', 'download')->where('aktif', 1)->get();;
		$info = DB::table('konten-landings')->where('jenis', 'info')->where('aktif', 1)->get();;
		$banner = DB::table('konten-landings')->where([
									['jenis', 'banner'],
									['aktif', 1],
								])->get();
		//where('jenis', 'banner')->where('aktif', 1)->get();;
		$pendaftaran = DB::table('konten-landings')->where('jenis', 'pendaftaran')->where('aktif', 1)->get();;
		//print_r($sambutan[0]);
		return view('pages.depan.index',[
			'sambutan' => $sambutan,
			'download' => $download,
			'info' => $info,
			'pendaftaran' => $pendaftaran,
			'banner' => $banner,
		]);
		//return view('pages.dashboard.index');
    }
	public function show()
    {
       
        return view('landing');
    }   
	public function daftarmhs()
    {
      return view('pages.depan.regma');
    }   
	
	public function update(RegistrasiRequest $request, $id)
    {
        $validated = $request->validated();
       // $updateIdentitas = $this->identitasUniversitasDao->update($id, $validated);

        if ($updateIdentitas->isOk) {
            $request->session()->flash('message', $updateIdentitas->message);
            return redirect()->back();
        } else {
            $request->session()->flash('error', $updateIdentitas->message);
            return redirect()->back()->withInput();
        }
    }
	
	public function storemhs(RegistrasiRequest $request)
    {
        $post = new RegistrasiMbkm;
		
        //$post->id_registrasi = $request->id_registrasi;
        $post->mahasiswa_id = $request->mahasiswa_id;
		$post->program_id = $request->program_id;
        //$post->dosen_dpl_id = $request->dosen_dpl_id;
		$post->tahun_ajaran_id = $request->tahun_ajaran_id;
		$post->kelas_id = 1;
		
        $post->save(); 
		/*
		$validated = $request->validated();
        $insertIdentitas = $this->RegistrasiDao->insert($validated);

        if ($insertIdentitas->isOk) {
            $request->session()->flash('message', $insertIdentitas->message);
            return redirect()->back();
        } else {
            $request->session()->flash('error', $insertIdentitas->message);
            return redirect()->back()->withInput();
        }
		*/
    }
}
