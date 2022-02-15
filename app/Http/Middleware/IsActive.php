<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $condiction=false;
        if(Auth::user()->school->Active){
            $condiction=true;
        }

        $method = $request->method();
        if($condiction){
            return $next($request);
        }else{
            $school_name=Auth::user()->school->School_Name;
            Auth::logout();
            return redirect()->route('login')->with('login_error_msg', '由於沒有繳費，您的安親班「'.$school_name.'」已被停用!');
        }
      
    }
}
