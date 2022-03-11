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
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $classsRepo;
    protected $studentRepo;
    protected $signinRepo;
    protected $messageRepo;
    protected $schoolRepo;
    protected $roleRepo;
    protected $userRepo;
    //protected $global_test;
    public function __construct(ClasssRepository $classsRepo,StudentRepository $studentRepo,MessageRepository $messageRepo,SigninRepository $signinRepo,SchoolRepository $schoolRepo, RoleRepository $roleRepo,UserRepository $userRepo)
    {
        //$this->middleware(['auth','verified']);
        $this->middleware('auth');
        $this->classsRepo=$classsRepo;
        $this->studentRepo=$studentRepo;
        $this->signinRepo=$signinRepo;
        $this->messageRepo=$messageRepo;
        $this->schoolRepo=$schoolRepo;
        $this->roleRepo=$roleRepo;
        $this->userRepo=$userRepo;
        //$this->global_test="global_test123123";
        //View::share("global_test",$this->global_test);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $now = date('Y-m-d H:i:s');
        return view('index',['now'=>$now]);
    }
    /*public function document1(){
        $pdf_path=url('document1.pdf');
        return response()->file($pdf_path);
    }*/
    public function check_authority($permission){
        $allow=false;
        $page="?";
        switch($permission){
            case 'classs':
                $page="班級";
                if(str_contains(Auth::user()->role->authority, 'classs')){
                    $allow=true;
                }
                break;
            case 'sign':
                $page="簽到退查詢";
                if(str_contains(Auth::user()->role->authority, 'sign')){
                    $allow=true;
                }
                break;
            case 'message':
                $page="訊息";
                if(str_contains(Auth::user()->role->authority, 'message')){
                    $allow=true;
                }
                break;
            case 'line':
                $page="LINE串接";
                if(str_contains(Auth::user()->role->authority, 'line')){
                    $allow=true;
                }
                break;
            case 'sys':
                $page="設定";
                if(str_contains(Auth::user()->role->authority, 'sys')){
                    $allow=true;
                }
                break;
            case 'account':
                $page="帳號權限";
                if(str_contains(Auth::user()->role->authority, 'account')){
                    $allow=true;
                }
                break;
            default:
                $allow=false;
                $page="?";
        }

        $permission_msg="很抱歉，您沒有存取"."「".$page."」"."頁面的權限";
        $result=array();
        $result[0]=$allow;
        $result[1]=$permission_msg;
        return $result;
        //return $allow;
        /*if(!$allow){
            return redirect()->route('classs.classs')->with('error_msg', '您沒有存取此頁面的權限');
        }*/
    }
    public function classs(){
        $permission=$this->check_authority('classs');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $school_classs=Auth::user()->school->classs;
        $school_batch=Auth::user()->school->batch;
        //$all_student=$this->studentRepo->get_all_student();
        $all_student=Auth::user()->school->student->sortBy('order')->sortBy('Classs_id')->values();
        //$all_student=Auth::user()->school->student;
        /*if(isset(Auth::user()->school->LineChannelAccessToken) && isset(Auth::user()->school->LineChannelSecret)){
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(Auth::user()->school->LineChannelAccessToken);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => Auth::user()->school->LineChannelSecret]);
            foreach($all_student as $all_st){
                $parent_line_multi=$all_st['parent_line_multi'];
                if(isset($parent_line_multi)){
                    $parent_name=array();
                    $parent_line_multi=json_decode($parent_line_multi,true);
                    foreach($parent_line_multi as $userId){
                        $profile_rsp=$bot->getProfile($userId);
                        $profile=($profile_rsp->isSucceeded()) ? $profile_rsp->getJSONDecodedBody() : null;
                        if(isset($profile))
                        array_push($parent_name,$profile['displayName']);
                        else
                        array_push($parent_name,"???");
                    }
                    $all_st['parent_line_multi']=json_encode($parent_name);
                }
            }
        }*/
        //echo $all_student;
        if(isset($_GET['success_msg'])){
            return redirect()->route('classs.classs')->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('classs.classs')->with('error_msg', $_GET['error_msg']);
        }else{
            return view('classs.classs',['school_classs'=>$school_classs,'school_batch'=>$school_batch,'all_student'=>$all_student]);
        }
    }

    public function student($id){
        $permission=$this->check_authority('classs');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $this_classs=$this->classsRepo->find($id);
        $classs_student_db=json_decode($this->studentRepo->get_student($id),true);

        $price = array();
        foreach ($classs_student_db as $key => $row)
        {
            $price[$key] = $row['order'];
        }
        array_multisort($price, SORT_ASC, $classs_student_db);
        $classs_student=$classs_student_db;

        /*$classs_student=array();
        for( $i=1; $i<=count($classs_student_db); $i++){
            foreach($classs_student_db as $student){

                if($student->order==$i){
                    array_push($classs_student,$student);
                }

            }
        }*/
        if(isset($_GET['success_msg'])){
            return redirect()->route('classs.student',$id)->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('classs.student',$id)->with('error_msg', $_GET['error_msg']);
        }else{
            return view('classs.student',['this_classs'=>$this_classs,'classs_student'=>$classs_student]);
        }
    }
    public function batch(){
        $permission=$this->check_authority('classs');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $school_classs=Auth::user()->school->classs;
        $school_batch=Auth::user()->school->batch;
        if(isset($_GET['success_msg'])){
            return redirect()->route('batch')->with('success_msg', $_GET['success_msg']);
        }elseif(isset($_GET['error_msg'])){
            return redirect()->route('batch')->with('error_msg', $_GET['error_msg']);
        }else{
            return view('batch',['school_classs'=>$school_classs,'school_batch'=>$school_batch]);
        }
    }
    public function basic(){
        $permission=$this->check_authority('sys');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        return view('basic');
    }
    public function self_profile(){
        return view('self_profile');
    }
    public function role(){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $roles=Auth::user()->school->role;
        return view('role.role',['roles'=>$roles]);
    }
    public function role_create(){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        return view('role.create');
    }
    public function role_edit($RoleID){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $roles = $this->roleRepo->find($RoleID);
        return view('role.edit', ['roles' => $roles]);
    }
    public function account(){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $accounts=Auth::user()->school->User;
        return view('account.account',['accounts'=>$accounts]);
    }
    public function account_create(){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $roles=Auth::user()->school->role;
        return view('account.create', ['roles' => $roles]);
    }
    public function account_edit($id){
        $permission=$this->check_authority('account');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $account = $this->userRepo->find($id);
        $roles=Auth::user()->school->role;
        return view('account.edit', ['account' => $account, 'roles' => $roles]);
    }

    public function line(){
        $permission=$this->check_authority('line');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $school=Auth::user()->school;
        /*if($school->id==2){
            $rich_menu_a=$this->del_rich_menu($school,$school->LineChannelAccessToken);
            $rich_menu_a=json_decode($rich_menu_a,true);
            $authorization = "Authorization: Bearer " . $school->LineChannelAccessToken;
            $ch = curl_init();
            foreach($rich_menu_a as $r_id){
                $url_2 = "https://api.line.me/v2/bot/richmenu/".$r_id;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_URL, $url_2);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $json_result = curl_exec($ch);
            }
            curl_close($ch);
            $rich_menu_a="ccc";

        }else{
            $test=null;
        }*/
        return view('line',['school'=>$school]);
    }
    public function line_notify(){
        $permission=$this->check_authority('line');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $school=Auth::user()->school;
        return view('line_notify',['school'=>$school]);
    }
    public function signin(){
        $permission=$this->check_authority('sign');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $today=date('Y-m-d');
        $school_classs=Auth::user()->school->classs;
        return view('signin.signin',['today'=>$today,'school_classs'=>$school_classs]);
    }
      public function signin_overview(){
        $permission=$this->check_authority('sign');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $t=time();
        $today=date('Y-m-d');
        $date_array = array(
            "center"=>date("Y-m-d",$t),
            "+1"=> date( "Y-m-d", strtotime( "+1 days" ) ),
            "+2"=> date( "Y-m-d", strtotime( "+2 days" ) ),
            "+3"=> date( "Y-m-d", strtotime( "+3 days" ) ),
            "+4"=> date( "Y-m-d", strtotime( "+4 days" ) ),
            "+5"=> date( "Y-m-d", strtotime( "+5 days" ) ),
            "-1"=> date( "Y-m-d", strtotime( "-1 days" ) ),
            "-2"=> date( "Y-m-d", strtotime( "-2 days" ) ),
            "-3"=> date( "Y-m-d", strtotime( "-3 days" ) ),
            "-4"=> date( "Y-m-d", strtotime( "-4 days" ) ),
            "-5"=> date( "Y-m-d", strtotime( "-5 days" ) ),
        );
        $date_result=$this->signinRepo->getmultidata($date_array);
        return view('signin.overview',['today'=>$today,'date_result'=>$date_result]);
    }
    public function update_chart(Request $request){
        $update_date=$request['update_date'];
        $date_array = array(
            "center"=>date( "Y-m-d", strtotime($update_date)),
            "+1"=> date( "Y-m-d", strtotime('+1 day', strtotime($update_date))),
            "+2"=> date( "Y-m-d", strtotime('+2 day', strtotime($update_date))),
            "+3"=> date( "Y-m-d", strtotime('+3 day', strtotime($update_date))),
            "+4"=> date( "Y-m-d", strtotime('+4 day', strtotime($update_date))),
            "+5"=> date( "Y-m-d", strtotime('+5 day', strtotime($update_date))),
            "-1"=> date( "Y-m-d", strtotime('-1 day', strtotime($update_date))),
            "-2"=> date( "Y-m-d", strtotime('-2 day', strtotime($update_date))),
            "-3"=> date( "Y-m-d", strtotime('-3 day', strtotime($update_date))),
            "-4"=> date( "Y-m-d", strtotime('-4 day', strtotime($update_date))),
            "-5"=> date( "Y-m-d", strtotime('-5 day', strtotime($update_date))),
        );
        $date_result=$this->signinRepo->getmultidata($date_array);
        return json_encode($date_result);
    }
    public function signin_result($q_type,$classs_id, $date){
        $permission=$this->check_authority('sign');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        $dayofweek_ = date('w', strtotime($date));
        $dayofweek =' ('.'星期' . ['日', '一', '二', '三', '四', '五', '六'][$dayofweek_].')';
        if($q_type=="c"){
            if($classs_id!="all_classs"){
                $classs=$this->classsRepo->find($classs_id);
                $classs_name=$classs->Classs_Name;
                $student=$classs->student;
                $signin=$this->signinRepo->get_signin($classs_id,$date);
                //$signin=$this->signinRepo->get_signin($classs_id,$date)->reverse()->values();
                return view('signin.result',['q_type'=>$q_type,'signin'=>$signin,'date'=>$date,'student'=>$student,'classs_name'=>$classs_name,'dayofweek'=>$dayofweek]);
            }else{
                $classs_name="不分班級";
                $student=Auth::user()->school->student->sortBy('Classs_id')->values();
                $signin=Auth::user()->school->signin->where('created_date',$date);
                //$signin=Auth::user()->school->signin->where('created_date',$date)->reverse()->values();
                $all_classs=Auth::user()->school->classs;
                return view('signin.result',['q_type'=>$q_type,'signin'=>$signin,'date'=>$date,'student'=>$student,'classs_name'=>$classs_name,'all_classs'=>$all_classs,'dayofweek'=>$dayofweek]);
            }
        }
        if($q_type=="s2"){
            $student=$this->studentRepo->find_stid($classs_id);
            if($student){
                $classs=$this->classsRepo->find($student->Classs_id);
                $signin=Auth::user()->school->signin->where('Student_id',$student->id)->reverse()->values();
                return view('signin.result',['q_type'=>$q_type,'signin'=>$signin,'date'=>$date,'student'=>$student,'st_id'=>$classs_id,'classs'=>$classs]);
            }else{
                return redirect()->route('signin.signin')->with('error_msg', "查無學生資料，請檢查輸入是否正確");
            }
        }
        if($q_type=="s1"){
            $student=$this->studentRepo->search_name($classs_id);
            if(count($student)!=0){
                //$student=Auth::user()->school->student;
                $classs=Auth::user()->school->classs;
                $signin=Auth::user()->school->signin->where('Student_Name',$classs_id)->reverse()->values();
                return view('signin.result',['q_type'=>$q_type,'signin'=>$signin,'date'=>$date,'student'=>$student,'st_Name'=>$classs_id,'classs'=>$classs]);
            }else{
                return redirect()->route('signin.signin')->with('error_msg', "查無學生資料，請檢查輸入是否正確");
            }
        }
    }
    public function message(Request $request){
        $permission=$this->check_authority('message');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        //dd($request->all());
        $school_classs=Auth::user()->school->classs;
        //$school_batch=Auth::user()->school->batch;
        $all_student=Auth::user()->school->student;
        //$all_student=$this->messageRepo->get_all_student();
        $all_message=$this->messageRepo->get_all_message();
        if(isset($_GET['success_msg'])){
            return redirect()->route('message')->with('success_msg', $_GET['success_msg']);
        }
        elseif(isset($_GET['error_msg'])){
            return redirect()->route('message')->with('error_msg', $_GET['error_msg']);
        }
        else{
            return view('message',['school_classs'=>$school_classs,'all_student'=>$all_student,'all_message'=>$all_message]);
        }

    }
    public function system(){
        $permission=$this->check_authority('sys');
        if(!$permission[0]){
            return redirect()->route('home')->with('error_msg', $permission[1]);
        }
        return view('system');
    }
    public function del_rich_menu($school,$access_token){
        $authorization = "Authorization: Bearer " . $access_token;
        $richMenuId=null;

        $url_1 = "https://api.line.me/v2/bot/richmenu/list";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_URL, $url_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $json_result = curl_exec($ch);
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus == 200) {
            $richmenus_a=array();
            $result=json_decode($json_result,true);
	        $richmenus=$result['richmenus'];
            foreach($richmenus as $r){
                array_push($richmenus_a,$r['richMenuId']);
            }
            $result=json_encode($richmenus_a);
        }else{
            $result="http_error_1";
        }
        curl_close($ch);
        return $result;
    }
    public function downloadPID(){
        $school=Auth::user()->school;
        $contents = $school->School_Name."的平台序號為: ".$school->PID;
        $filename = '平台序號.txt';
        return response()->streamDownload(function () use ($contents) {
            echo $contents;
        }, $filename);
    }
}

