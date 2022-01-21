<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClasssRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SigninRepository;
use Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\MessageRepository;
use App\Repositories\SchoolRepository;

class AdminController extends Controller
{
    protected $classsRepo;
    protected $studentRepo;
    protected $signinRepo;
    protected $messageRepo;
    protected $schoolRepo;

    public function __construct(ClasssRepository $classsRepo,StudentRepository $studentRepo,MessageRepository $messageRepo,SigninRepository $signinRepo,SchoolRepository $schoolRepo)
    {
       
        $this->classsRepo=$classsRepo;
        $this->studentRepo=$studentRepo;
        $this->signinRepo=$signinRepo;
        $this->messageRepo=$messageRepo;
        $this->schoolRepo=$schoolRepo;
    }
    public function init_session($request,$key,$value){
        $request->session()->put($key, $value);
    }
    public function forget_session($request,$key){
        $request->session()->forget($key);
    }
    
    public function index()
    {
        if(session()->has('admin')&&session()->get('admin')==true){
            return redirect()->route('admin.home');
        }else{
            return view('admin.index');
        }
       
    }
    public function login(Request $request){
        $admin_account="root";
        $admin_password="2wsx(OL>";
        $ban_msg="登入失敗! 你已被暫時禁止登入";

        if($request['admin_account']==$admin_account && $request['admin_password']==$admin_password){
            if(session()->has('admin_error_count')){
                $error_count=session()->get('admin_error_count');
                if($error_count==0){
                    return redirect()->route('admin.index')->with('error_msg', $ban_msg);
                }
            }
            $this->init_session($request,'admin',true);
            $this->forget_session(request(),'admin_error_count');
            return redirect()->route('admin.home')->with('success_msg', "您已成功登入！");
        }else{
            
            if(session()->has('admin_error_count')){
                $error_count=session()->get('admin_error_count');
                if($error_count>0){
                    $error_count--;
                }else{
                    $error_count=0;
                }
            }else{
                $error_count=3;
            }
            
        
            if($error_count==0){
                $message=$ban_msg;
            }else{
                $message="帳號或密碼錯誤！ 您還可以嘗試".$error_count."次";
            }

            $this->init_session($request,'admin_error_count',$error_count);

            return redirect()->route('admin.index')->with('error_msg', $message);
        }
    }
    
    public function home(){
        return view('admin.home');
    }

    public function logout(Request $request){
        $this->forget_session(request(),'admin');
        $this->forget_session(request(),'admin_error_count');
        return redirect()->route('admin.index')->with('normal_msg', "您已登出！");
    }
}
