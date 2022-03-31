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
use App\Repositories\SubscribeRepository;
use App\Models\School;

class AdminController extends Controller
{
    protected $classsRepo;
    protected $studentRepo;
    protected $signinRepo;
    protected $messageRepo;
    protected $schoolRepo;
    protected $subscribeRepo;
    protected $exclude_school=array(3,4,5,6,7,8,9,10,11,12,13);

    public function __construct(ClasssRepository $classsRepo,StudentRepository $studentRepo,MessageRepository $messageRepo,SigninRepository $signinRepo,SchoolRepository $schoolRepo,SubscribeRepository $subscribeRepo)
    {
        //$this->exclude_school=array();
        $this->classsRepo=$classsRepo;
        $this->studentRepo=$studentRepo;
        $this->signinRepo=$signinRepo;
        $this->messageRepo=$messageRepo;
        $this->schoolRepo=$schoolRepo;
        $this->subscribeRepo=$subscribeRepo;
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
        $today=date('Y-m-d');
        $exclude_school=$this->exclude_school;
        //$exclude_school=array();
        $schools=$this->schoolRepo->list_all();
        $schools_a=array();
        foreach($schools as $index=>$school){
            if(in_array($school->id, $exclude_school)){
                //unset($schools[$index]);
            }else{
                array_push($schools_a,$school);
            }
        }
        $subscribes=$this->subscribeRepo->list_all();

        return view('admin.home',['schools'=>$schools_a,'subscribes'=>$subscribes,'today'=>$today]);
    }

    public function logout(Request $request){
        $this->forget_session(request(),'admin');
        $this->forget_session(request(),'admin_error_count');
        return redirect()->route('admin.index')->with('normal_msg', "您已登出！");
    }
    public function update_plan(Request $request){
        $school_id=$request['school_id'];
        $plan=$request['plan'];
        $school=$this->schoolRepo->find($school_id);
        if($plan=="none"){
            $result=$school? $school->update(array('plan'=>null)) : false;
        }else{
            $result=$school? $school->update(array('plan'=>$plan)): false;
        }
        
        if($result){
            switch($plan){
                case 'month':
                    $planName="月繳";
                    break;
                case 'season':
                    $planName="季繳";
                    break;
                case 'year':
                    $planName="年繳";
                    break;
                case 'none':
                    $planName="無";
                    break;

            }
            return redirect()->route('admin.home')->with('success_msg', "更新成功！".$school->School_Name."的方案已變更為"."「".$planName."」");
        }else{
            return redirect()->route('admin.home')->with('error_msg', "更新失敗！");
        }

    }
    public function store_subscribe(Request $request){
        $school_id=$request['school_id'];
        $school=$this->schoolRepo->find($school_id);
        $result=$this->subscribeRepo->store($request->all());
        if($result[0]){
            return redirect()->route('admin.home')->with('success_msg', "新增成功！".$school->School_Name."已新增訂單".$result[1]);
        }else{
            return redirect()->route('admin.home')->with('error_msg', "新增失敗！");
        }
    }
    public function update_subscribe(Request $request){
        //dd($request->all());
        $subscribe_id=$request['subscribe_id'];
        $subscribe=$this->subscribeRepo->find($subscribe_id);
        if ($request->has('delete')) {
            $result=$this->subscribeRepo->delete($subscribe_id);
            if($result){
                return redirect()->route('admin.home')->with('success_msg', "刪除成功！".$subscribe->school->School_Name."已刪除訂單");
            }else{
                return redirect()->route('admin.home')->with('error_msg', "刪除失敗！");
            }
        }else{
            $result=$this->subscribeRepo->update($subscribe_id,$request->all());
            if($result[0]){
                return redirect()->route('admin.home')->with('success_msg', "更新成功！".$subscribe->school->School_Name."已更新訂單".$result[1]);
            }else{
                return redirect()->route('admin.home')->with('error_msg', "更新失敗！");
            }
        }
    }
    public function change_active(Request $request,$id){
        //dd($request->all());
        $school=$this->schoolRepo->find($id);
        if($request->input('current_status')==1){
            $new_status=0;
        }elseif($request->input('current_status')==0){
            $new_status=1;
        }
        $result=$this->schoolRepo->change_active($id,$new_status);
        if($result[1]==1){
            if($result[0]){
                return redirect()->route('admin.home')->with('success_msg', '「'.$school->School_Name.'」已啟用！');
            }else{
                return redirect()->route('admin.home')->with('error_msg', '「'.$school->School_Name.'」啟用失敗！');
            }
        }elseif($result[1]==0){
            if($result[0]){
                return redirect()->route('admin.home')->with('success_msg', '「'.$school->School_Name.'」已停用！');
            }else{
                return redirect()->route('admin.home')->with('error_msg', '「'.$school->School_Name.'」停用失敗！');
            }
        }
    }
    public function query_due(Request $request){
        $exclude_school=$this->exclude_school;
        //$exclude_school=array();
        $result=$this->subscribeRepo->query_due($request['query_date'],$request['query_weeks'],$exclude_school);
        return json_encode($result);
    }
    public function update_device_id(Request $request){
        $school_id=$request['school_id'];
        $device_id=$request['device_id'];
        $school=$this->schoolRepo->find($school_id);
        $school->device_id=$device_id;
        if($school->isDirty('device_id')){
            $result=$this->schoolRepo->update_device_id($school_id,$device_id);
            if($result){
                return redirect()->route('admin.home')->with('success_msg', "更新成功！".$school->School_Name."已更新裝置");
            }else{
                return redirect()->route('admin.home')->with('error_msg', "更新失敗！".$school->School_Name."更新裝置失敗");
            }
        }else{
            return redirect()->route('admin.home')->with('normal_msg', $school->School_Name."的裝置沒有進行更動");
        }
      
    }
}
