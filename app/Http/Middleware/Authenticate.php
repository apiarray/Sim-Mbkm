<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {				
        if (! $request->expectsJson()) {
			return route('login');
        }
    }
}
/*
if(auth()->guard('mahasiswa')->check()){
				//echo 'asik';	
				//return route('logout_mahasiswa');
				}
			elseif(auth()->guard('dosen')->check()){
				//echo 'asik2';	
				//return route('logout_dosen');
				}			
			else {}
			
*/