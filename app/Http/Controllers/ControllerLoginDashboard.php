<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Pengguna\Mahasiswa;
use App\Models\Pengguna\DosenDpl;
use Hash;

class ControllerLoginDashboard extends Controller
{
	public function login(Request $request)
	{
		if ($request->role == "pengelola") {
			if ($data = User::where('email', $request->email)->first()) {
				$pass = Hash::check($request->password, $data->password);
				if ($pass) {
					$request->session()->put('nama', $data->name);
					$request->session()->put('role', $request->role);
					//	dd($request->all());
					return redirect('/dashboard');
				} else {
					return redirect('/logins');
				}
			} else {
			}
		} elseif ($request->role == "dosen") {
			if ($data = Mahasiswa::where('email', $request->email)->first()) {
				$pass = Hash::check($request->password, $data->password);
				if ($pass) {
				} else {
				}
			} else {
			}
		} else {
			if ($data = DosenDpl::where('email', $request->email)->first()) {
				$pass = Hash::check($request->password, $data->password);
				if ($pass) {
				} else {
				}
			} else {
			}
		}
	}
}
