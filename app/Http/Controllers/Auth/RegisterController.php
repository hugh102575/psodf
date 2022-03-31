<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\School;
use App\Models\role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'account' => ['required', 'string', 'max:50'],
            'admin' => ['required', 'string', 'max:50'],
            //'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:50','confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        /*return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        $PID_num="";
        $degit=5;
        for($i=0; $i<$degit; $i++){
            $PID_num=$PID_num.strval(rand(0,9));
        }
        $PID=strval("s").strval($PID_num);
        while(School::where('PID',$PID)->exists()) {
            $PID_num="";
            $degit=5;
            for($i=0; $i<$degit; $i++){
                $PID_num=$PID_num.strval(rand(0,9));
            }
            $PID=strval("s").strval($PID_num);
        }


        /*$PID=strval("s").strval(rand(10000,99999));
        while(School::where('PID',$PID)->exists()) {
            $PID=strval("s").strval(rand(10000,99999));
        }*/


        $now = date('Y-m-d H:i:s');
        School::create([
            'School_Name' => $data['school'],
            'PID' => $PID,
            'admin' => $data['admin'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            //'create_from' => $data['email'],
            'create_from' => $data['account'],
            'created_at' =>  $now,
            'latest_profile' =>  $now
        ]);
        //$my_school = School::where('create_from',$data['account'])->first();
        $my_school = School::where('PID',$PID)->first();

        role::create([
            'School_id' => $my_school->id,
            'Role_Name' => '安親班管理員',
            'Role_Desc' => '系統預設',
            'authority' => 'classs,sign,message,line,sys,account',
            'create_from' => 'system',
            'created_at' =>  $now
        ]);


        return User::create([
            'name' => $data['name'],
            'account' => $data['account'],
            //'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'School_id' =>  $my_school->id,
            'RoleID' => role::where('School_id',$my_school->id)->where('Role_Name','安親班管理員')->first()->RoleID,
        ]);
    }
}

