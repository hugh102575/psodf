<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\School;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(!Auth::user()->active) {
                Auth::logout();
                return redirect()->route('login')->with('login_error_msg', '登入失敗，您的帳號已被停用!');
            }
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('login_error_msg', '登入失敗，您輸入的登入資訊有誤!');
    }*/
    public function login(Request $request)
    {
        $request->validate([
            'PID' => 'required',
            'account' => 'required',
            'password' => 'required',
        ]);



        $school=School::where('PID',$request['PID'])->first();
        if($school){
            $school_id=$school->id;
        }else{
            $school_id="PID_error";
        }

        //$credentials = $request->only('account', 'password');
        $request->merge(["School_id"=>$school_id]);
        $credentials = $request->only('account', 'password','School_id');

        if (Auth::attempt($credentials)) {
            if(!Auth::user()->active) {
                Auth::logout();
                return redirect()->route('login')->with('login_error_msg', '登入失敗，您的帳號已被停用!');
            }
            $now = date('Y-m-d H:i:s');
            Auth::user()->update(array('last_login'=>$now));
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('login_error_msg', '登入失敗，您輸入的登入資訊有誤!');
    }

}

