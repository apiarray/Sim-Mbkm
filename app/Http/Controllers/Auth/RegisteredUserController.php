<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Masters\Program;
use App\Models\Masters\Semester;
use App\Models\Masters\TahunAjaran;
use App\Models\Masters\Mitra;
use App\Models\Masters\Fakultas;
use App\Models\Pengguna\DosenDpl;
use App\Providers\RouteServiceProvider;
use App\Models\Pengguna\Mahasiswa;
use App\Models\Aktivitas\RegistrasiMbkm;
use App\Models\Masters\Kelas;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
	public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
	
	public function create_mahasiswa()
    {
		$program = Program::all();
		$mitra = Mitra::all();
		$t_a = TahunAjaran::where('status', 'aktif')->get();
		$kelas = Kelas::get();
        return view('auth.register_mhs', compact('program','t_a','mitra', 'kelas'));
    }
	
	public function store_mahasiswa(Request $request)
    {
		$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tahun_ajaran' => ['required', 'exists:tahun_ajaran,id'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
        ]);
		
        DB::beginTransaction();
		$post = new Mahasiswa;
        $post->nim = $request->nim;
		$post->nama = $request->name;
        $post->password = Hash::make($request->password);
		$post->email= $request->email;
		$post->tahun_masuk = TahunAjaran::find($request->tahun_ajaran)->tahun_ajaran ?? date('Y');
		$post->jenis_pendaftaran = "baru";
		$post->status = $request->status;
        $post->save();
		$id_mahasiswa = $post->id;;
		
		$post = new RegistrasiMbkm;
        $post->mahasiswa_id = $id_mahasiswa;
		$post->program_id = $request->program;
		$post->tahun_ajaran_id = $request->tahun_ajaran;
		$post->kelas_id = $request->kelas_id ?? NULL;
        $post->save(); 
		
		$mitra = new Mitra;
		$mitra->nama = $request->mitra;
		$mitra->save();
        DB::commit();

        return redirect(RouteServiceProvider::HOME);
    }
	
	public function create_dosen()
    {
		$program = Program::all();
		$semester = Semester::all();
		$t_a = TahunAjaran::all();
		$fakultas= Fakultas::all();
        return view('auth.register_dos', compact('program','semester','t_a','fakultas'));
    }
	
	public function store_dosen(Request $request)
    {		 
		$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
		
		$post = new DosenDpl;		
        //$post->id_registrasi = $request->id_registrasi;
        $post->nip = $request->nip;
		$post->nama = $request->name;
        $post->password = Hash::make($request->password);
		$post->email= $request->email;
		$post->fakultas_id = $request->fakultas;
        $post->save();

        return redirect(RouteServiceProvider::HOME);
    }
}
