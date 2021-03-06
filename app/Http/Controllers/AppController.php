<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClasssRepository;
use App\Repositories\StudentRepository;
use App\Repositories\BatchRepository;
use App\Repositories\UserRepository;
use App\Repositories\SigninRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Support\Facades\Storage;
use App\Jobs\LineNotify;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Crypt;
use Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use ZipArchive;


class AppController extends Controller
{
    protected $classsRepo;
    protected $studentRepo;
    protected $batchRepo;
    protected $userRepo;
    protected $signinRepo;
    protected $schoolRepo;

    public function __construct(ClasssRepository $classsRepo,StudentRepository $studentRepo,BatchRepository $batchRepo,UserRepository $userRepo,SigninRepository $signinRepo,SchoolRepository $schoolRepo)
    {
        $this->classsRepo=$classsRepo;
        $this->studentRepo=$studentRepo;
        $this->batchRepo=$batchRepo;
        $this->userRepo=$userRepo;
        $this->signinRepo=$signinRepo;
        $this->schoolRepo=$schoolRepo;
    }
    public function api_test(){
        //$return_total=array();
        $return=array();
        $return['api_test']="ok";
        //array_push($return_total,$return);
        return json_encode($return);
    }

    public function check_active(Request $request){
        $active= $request->user()->school->Active;
        if($active==1){
            $active_boolean=true;
        }else{
            $active_boolean=false;
        }
        $return=array();
        $return['Active']=$active_boolean;
        return json_encode($return);
    }

    public function login(Request $request){
        $user=$this->userRepo->app_login($request->all());
        $return=array();
        if($user){
            if($user->school->device_id!=null){
                $device_id_db=json_decode($user->school->device_id,true);
                if (in_array($request['device_id'], $device_id_db)){
                //if($request['device_id']==$user->school->device_id){
                    $return['success']=true;
                    $return['api_token']=$user->api_token;
                    $return['school_name']=$user->school->School_Name;
                    $return['school_id']=$user->school->id;
                    $return['thresh']=$user->school->thresh;
                    $return['sign_mode']=$user->school->sign_mode;
                    $return['error_msg']="";
                    $return['backup_batch']=$user->school->batch;
                    $return['backup_classs']=$user->school->classs;
                    $return['backup_student']=$user->school->student;
                }else{
                    $return['success']=false;
                    $return['error_msg']="????????????????????????";
                }
            }else{
                $return['success']=false;
                $return['error_msg']="??????????????????";
                /*$return['success']=true;
                $return['api_token']=$user->api_token;
                $return['school_name']=$user->school->School_Name;
                $return['school_id']=$user->school->id;
                $return['thresh']=$user->school->thresh;
                $return['sign_mode']=$user->school->sign_mode;
                $return['error_msg']="";*/
            }
        }else{
            $return['success']=false;
            $return['error_msg']="?????????????????????";
        }
        return json_encode($return);

    }
    public function login_v2(Request $request){
        $result=$this->userRepo->app_login_v2($request->all());
        if($result[0]){
            $user=$result[0];
            $return['success']=true;
            $return['user_id']=$user->id;
            $return['api_token']=$user->api_token;
            $return['school_name']=$user->school->School_Name;
            $return['school_id']=$user->school->id;
            $return['thresh']=$user->school->thresh;
            $return['sign_mode']=$user->school->sign_mode;
            $return['error_msg']="";
            $return['backup_batch']=$user->school->batch;
            $return['backup_classs']=$user->school->classs;
            $return['backup_student']=$user->school->student;
            $return['latest_profile']=$user->school->latest_profile;

        }else{
            $return['success']=false;
            $return['error_msg']=$result[1];
        }
        return json_encode($return);
    }
    public function batch_find_class(Request $request,$id){
        $class=$request->user()->school->classs;
        $class_a=array();
        foreach($class as $c){
            if($c->Batch_id==$id){
                array_push($class_a,$c);
            }
        }
        return $class_a;
    }
    public function class_find_student(Request $request,$id){
        $student= $request->user()->school->student;
        $student_a=array();
        foreach($student as $st){
            if($st->Classs_id==$id){
                array_push($student_a,$st);
            }
        }
	$student_a_sort = collect($student_a)->sortBy('order')->values()->toArray();
        return $student_a_sort;
    }
    public function line_notify(Request $request){
        $school=$request->user()->school;
        $id=$request['id'];
        $student=$this->studentRepo->find($id);
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($school->LineChannelAccessToken);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $school->LineChannelSecret]);
        $return =array();
        if($student && $student->parent_line){
            $message="????????????".$student->name."???????????????!";
            $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
            $result=$bot->pushMessage($student->parent_line,$push_build);
            $return['status']=$result->getHTTPStatus();
        }else{
            $return['status']=404;
        }
        return json_encode($return);
    }

    public function notify_queue(Request $request){
        $school=$request->user()->school;
        $School_id=$school->id;
        $id=$request['id'];
        $student=$this->studentRepo->find($id);
        $classs=$student->classs;
        $sign=$request['sign'];
        if(isset($request['setTime'])){
            $setTime=$request['setTime'];
        }else{
            $setTime=null;
        }

        $new_img="image";
        $return=array();
        $return['status']="failed";
        if ($request->hasFile($new_img)){
            $file = $request->file($new_img);
            if ($file->isValid()){
                //if($student && $student->parent_line){
                if($student){
                    $date = date('Y_m_d_');
                    //$record=$this->signinRepo->find_record($id,$date);
                    //if($record){
                    //    $return['status']="signed";
                    //}else{
                        $extension = $file->getClientOriginalExtension();
                        $path = 'Notify/' .$School_id. '/'. $id . '/'.$date. uniqid('', true) . '.' . $extension;
                        $result=Storage::disk('public')->put($path, $request->file($new_img)->get());
                        if(Storage::disk('public')->exists($path))
                            $image_path = Storage::url($path);
                            

                        if($result && $image_path){
                            $today=date('Y-m-d');
                            $now = date('Y-m-d H:i:s');
                            LineNotify::dispatch($school,$student,$image_path,$sign,$now,$setTime);
                            $return['status']="successed";
                            /*
                            $signin=array();
                            $signin['School_id']=$School_id;
                            $signin['Classs_id']=$classs->id;
                            $signin['Student_id']=$id;
                            $signin['Classs_Name']=$classs->Classs_Name;
                            $signin['Student_Name']=$student->name;
                            $signin['sign']=$sign;
                            $signin['signin_img']=$image_path;
                            if(isset($setTime)){
                                $timestamp_ = strtotime($setTime);
                                $timestamp=date('Y-m-d', $timestamp_);
                                $signin['created_date']=$timestamp;
                            }else{
                                $signin['created_date']=$today;
                            }
                            if(isset($setTime)){
                                $timestamp_ = strtotime($setTime);
                                $timestamp=date('Y-m-d H:i:s', $timestamp_);
                                $signin['created_at']=$timestamp;
                            }else{
                                $signin['created_at']=$now;
                            }
                            $this->signinRepo->store($signin);*/
                        }
                    //}
                }
            }
        }
        return json_encode($return);
    }

    public function notify_bind(Request $request){
        $code=$request['code'];
        $state=$request['state'];
        $arr = explode('@', $state);
        if(count($arr)==5){
            $school_id=$arr[0];
            $student_id=$arr[1];
            $student=$this->studentRepo->find($student_id);
            $client_id=$arr[2];
            $client_secret=$arr[3];
            $userId_official=$arr[4];
        }
        
        if(count($arr)!=5){
            $message="?????????????????????1";
            return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('error_msg', $message);
        }else{
            $url="https://notify-bot.line.me/oauth/token"; 
            $obj =
                        [
                            'grant_type' => 'authorization_code',
                            'code' => $code,
                            'redirect_uri' =>  'https://yes-psodf.yesinfo.com.tw/notify_bind/',
                            'client_id' => $client_id,
                            'client_secret' => $client_secret
                            
                        ]
                    ;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($obj));

            $json_result = curl_exec($ch);
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $access_token=null;
            if ($resultStatus == 200) {
                $result=json_decode($json_result,true);
                $access_token=$result['access_token'];
            }
            curl_close($ch);

            if(isset($access_token)){
                $add_line=$this->studentRepo->add_parent_line3($student,$userId_official,$access_token);
                if($add_line){
                    $message="????????????!\n".$student->name."??????????????????\n"."???????????????????????????\n??????????????????????????????";
                    
                    $send_url="https://notify-api.line.me/api/notify";
                    $obj =
                            [
                                'message' => $message
                            ]
                        ;
                    $ch = curl_init();
                    $authorization = "Authorization: Bearer " . $access_token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data' , $authorization ));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_URL, $send_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
                    $json_result2 = curl_exec($ch);
                    curl_close($ch);

                    return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId_official))->with('success_msg', $message);

                }else{
                    $message="?????????????????????3";
                    return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId_official))->with('error_msg', $message);
                }
                //echo json_encode($result);
                //return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>"NotifyToken@".$access_token));
            }else{
                $message="?????????????????????2";
                return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId_official))->with('error_msg', $message);
            }
        }

        /*if(isset($access_token)){
            echo $access_token;
            $send_url="https://notify-api.line.me/api/notify";

            $path = 'Notify/1/120/'.'2022_02_16_620c98ffd2fb17.58830293.jpg';
            $image_path = Storage::url($path);
            $image_url=str_replace('http://','https://',url($image_path));
            $msg="????????????";
            $obj2 =
                    [
                        'message' => $msg,
                        'imageThumbnail'=> $image_url,
                        'imageFullsize' =>$image_url
                    ]
                ;
            $ch2 = curl_init();
            $authorization = "Authorization: Bearer " . $access_token;
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data' , $authorization ));
            curl_setopt($ch2, CURLOPT_POST, 1);
            curl_setopt($ch2, CURLOPT_URL, $send_url);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $obj2);
            $json_result2 = curl_exec($ch2);
            curl_close($ch2);
            echo json_encode($json_result2);
        }else{
            echo "no access_token";
        }*/
        
        //echo json_encode($access_token);
    }

    public function profile(Request $request){
        $school=$request->user()->school;
        $School_id=$school->id;
        $id=$request['id'];
        $profile_time=$request['profile_time'];
        $student=$this->studentRepo->find($id);

        $new_img="image";
        $return=array();
        $return['status']="failed";
        if ($request->hasFile($new_img)){
            $file = $request->file($new_img);
            $origin_name=$request->file($new_img)->getClientOriginalName();
            if ($file->isValid()){
                if($student){
                    $date = date('Y_m_d_');
                    $extension = $file->getClientOriginalExtension();
                    $path = 'Profile/' .$School_id. '/'. $id . '/'.$date. uniqid('', true) . '.' . $extension;
                    //$path = 'Profile/' .$School_id. '/'. $id . '/'.$origin_name;

                    $result=Storage::disk('public')->put($path, $request->file($new_img)->get());
                    if(Storage::disk('public')->exists($path))
                        $image_path = Storage::url($path);

                    if($result && $image_path){
                        
                        if(isset($profile_time)){
                            $school->update(array('latest_profile'=>$profile_time)) ;
                        }
                        $this->studentRepo->profile($id,$image_path);
                        $return['status']="successed";
                    }

                }
            }
        }
        return json_encode($return);
    }

    public function bind($school_id,$LineID){
        $school=$this->schoolRepo->find($school_id);
        //$decode=base64_decode(str_replace('_','/',$LineID));
        //return view('bind',['school'=>$school,'LineID'=>$decode]);
        return view('bind',['school'=>$school,'LineID'=>$LineID]);
    }
    public function bind_update(Request $request){
        //dd($request->all());
        $userId=$request['LineID'];
        $stid=$request['stid'];
        $school_id=$request['school_id'];
        if(!str_contains($userId, 'NotifyToken')){
            $mode="official";
            $userId_real=$userId;
        }else{
            $mode="notify";
            $arr = explode('@', $userId);
            $userId_real = $arr[1];    
        }
        $school=$this->schoolRepo->find($school_id);
        $student=$this->studentRepo->check_stuid($stid,$school_id);
        if($student){
            $check=false;
            $multi_line=$student->parent_line_multi;
            if(isset($multi_line)){
                $multi_line_d=json_decode($multi_line,true);
                if (in_array($userId_real, $multi_line_d)){
                    $check=false;
                }else{
                    $check=true;
                }
            }else{
                $check=true;
            }
           
            if($check){
                //$p_client_id="RRLsQUWlfQYbspJCJH5KTx";
                //$p_client_secret="24xjchpNgX94Gg84wPuRfsImyejApEgWrp0yN2QS0OS";
                $p_client_id=$school->ClientId;
                $p_client_secret=$school->ClientSecret;
                $state_string=$school_id."@".$student->id."@".$p_client_id."@".$p_client_secret."@".$userId_real;
                if(isset($state_string)){
                    return Redirect::to('https://notify-bot.line.me/oauth/authorize?response_type=code&scope=notify&client_id='.$p_client_id.'&redirect_uri=https://yes-psodf.yesinfo.com.tw/notify_bind/&state='.$state_string);
                }else{
                    $message="?????????????????????4";
                    return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('error_msg', $message);
                }
            }else{
                $message="?????????".$student->name."????????????\n"."??????????????????????????????";
                return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('normal_msg', $message);
            }
            //return Redirect::to('https://notify-bot.line.me/oauth/authorize?response_type=code&scope=notify&client_id=RRLsQUWlfQYbspJCJH5KTx&redirect_uri=https://yes-psodf.yesinfo.com.tw/notify_bind/&state=1@120@RRLsQUWlfQYbspJCJH5KTx@24xjchpNgX94Gg84wPuRfsImyejApEgWrp0yN2QS0OS');
            
            /*$add_line=$this->studentRepo->add_parent_line2($student,$userId_real,$mode);
            if($add_line){
                if ($mode=="official") { 
                    $message="????????????!\n".$student->name."??????????????????\n"."???????????????????????????\n??????????????????????????????";
                    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($school->LineChannelAccessToken);
                    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $school->LineChannelSecret]);
                    $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $push_result=$bot->pushMessage($userId_real,$push_build);
                }else if($mode=="notify"){
                    $message="????????????!\n".$student->name."??????????????????\n"."???????????????????????????\n??????????????????????????????";
                    $send_url="https://notify-api.line.me/api/notify";
                    $obj =
                            [
                                'message' => $message
                            ]
                        ;
                    $ch = curl_init();
                    $authorization = "Authorization: Bearer " . $userId_real;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data' , $authorization ));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_URL, $send_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $obj);
                    $json_result2 = curl_exec($ch);
                    curl_close($ch);
                }

                return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('success_msg', $message);
            }else{
                $message="?????????".$student->name."????????????\n"."??????????????????????????????";
                return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('normal_msg', $message);
            }*/
        }else{
            $message="?????????????????????\n???????????????????????????";
            return redirect()->route('bind',array('school_id'=>$school_id,'LineID'=>$userId))->with('error_msg', $message);
        }
    }
    public function manual_sign_check(Request $request){
        $find=false;
        $stid=$request['stid'];
        $school_id=$request['school_id'];
        $student=$this->studentRepo->check_stuid($stid,$school_id);
        if($student){
            $classs=$this->classsRepo->find($student->Classs_id);
            $find=true;
            $type="single";
        }else{
            $student_a=$this->studentRepo->check_stuName($stid,$school_id);
            if(count($student_a)==1){
                $student=$student_a[0];
                $classs=$this->classsRepo->find($student->Classs_id);
                $find=true;
                $type="single";
            }elseif(count($student_a)>1){
                $find=true;
                $type="multi";
            }else{
                $error_msg="not found";
            }
        }
        $return=array();
      
        if($find){
        //if($student && $classs){
            if($type=="single"){
                $return['found']=true;
                $return['name']=$student->name;
                $return['id']=$student->id;
                $return['classs']=$classs->Classs_Name;
                $return['STU_id']=$student->STU_id;
                $return['type']="single";
            }elseif($type=="multi"){
                $student_a_id=array();
                $student_a_name=array();
                $student_a_STU_id=array();
                $student_a_classs=array();
                foreach($student_a as $st){
                    array_push($student_a_id,$st->id);
                }
                foreach($student_a as $st){
                    array_push($student_a_name,$st->name);
                }
                foreach($student_a as $st){
                    array_push($student_a_STU_id,$st->STU_id);
                }
                foreach($student_a as $st){
                    $c=$this->classsRepo->find($st->Classs_id);
                    array_push($student_a_classs,$c->Classs_Name);
                }
                $return['found']=true;
                $return['type']="multi";
                $return['student_a_id']=$student_a_id;
                $return['student_a_name']=$student_a_name;
                $return['student_a_STU_id']=$student_a_STU_id;
                $return['student_a_classs']=$student_a_classs;
            }
        }else{
            $return['found']=false;
            $return['error_msg']=$error_msg;
        }
        
        return json_encode($return);
    }

    public function check_latest_profile(Request $request){
        $return=array();
        $return['latest_profile']=$request->user()->school->latest_profile;
        return json_encode($return);
    }
    public function school_all_students(Request $request){
        $students=$request->user()->school->student;
        return $students;
    }

    public function supervise($school_id,$LineID){
        $school=$this->schoolRepo->find($school_id);
        $student=$this->studentRepo->parent_supervise($school_id,$LineID);
        if(count($student)!=0){
            $signin=$this->signinRepo->parent_supervise($school_id,$student);
        }else{
            $signin=array();
        }
        return view('supervise',['school'=>$school,'student'=>$student,'signin'=>$signin]);
    }

    public function costom_reset_pwd(Request $request){
        //dd($request->all());
        $school=School::where('PID',$request['PID'])->first();
        if($school){
            $school_id=$school->id;
        }else{
            $school_id="PID_error";
        }
        $user = User::where('School_id',$school_id)->where('account',$request['account'])->first();

        //$user = User::where('PID',$request['PID'])->where('account',$request['account'])->first();
        if($user){
            return redirect()->route('costom_reset_pwd_form',['id'=>Crypt::encryptString($user->id)]);
        }else{
            return redirect()->back()->with('status', "??????????????????????????????????????????");
        }

    }
    public function costom_reset_pwd_form($id){
        try {
            $id = Crypt::decryptString($id);
            $user=$this->userRepo->find($id);
            $school=$this->schoolRepo->find($user->School_id);
            return view('auth.passwords.reset2',['user'=>$user,'school'=>$school]);
        } catch (DecryptException $e) {
            //
        }
    }
    public function costom_reset_pwd_form_post($id,Request $request){
        //dd($request->all());
        //echo $id;
        $messages = [
            'required'    => '??????????????????',
            //'email.unique'    => '??????????????????????????????',
            'password.regex' => '??????????????????????????????',
            'password.confirmed' => '?????????????????????',
            'max' => '??????????????????????????????:max',
            'min' => '??????????????????????????????:min',
        ];
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|max:50|confirmed',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user=$this->userRepo->find($id);
        $result=  $user ? $user->update(array('password'=>Hash::make($request['password']))) : false;
        if($result){
            Auth::logout();
            return redirect()->route('login')->with('login_success_msg', '?????????????????????????????????!');
        }else{
            Auth::logout();
            return redirect()->route('login')->with('login_error_msg', '??????????????????');
        }
        
    }

    public function download_backup(Request $request){

        $school_id= $request->user()->school->id;
        $school_id_str=strval($school_id);
        /*$path = 'Profile/1/120/'.'2022_03_14_622ebc26b12915.42976068.jpg';
        $image_path=url('storage/'.$path);
        
        $filename = 'temp-image.jpg';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($image_path, $tempImage);

        return response()->download($tempImage, $filename);*/


      
        //$pathtest = 'Profile/1/120/'.'2022_03_14_622ebc26b12915.42976068.jpg';

        
        $source_path = '/Profile/' . $school_id_str;
        $zip      = new ZipArchive;
        $filename ='Student_Profile@' . $school_id_str . '.zip';
        $zip_path=Storage::url($filename);
       
        
        $oldfile = public_path($zip_path);
        if(file_exists($oldfile)){
            Storage::disk('public')->delete($filename);
        }
        if ($zip->open(public_path($zip_path), ZipArchive::CREATE) === TRUE) {
            $this->addContent($zip, public_path(Storage::url($source_path)));
            $zip->close();
            return response()->download(public_path($zip_path));
        }
        
  


       

       



       
    }

    private function addContent(\ZipArchive $zip, string $path)
    {
        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::FOLLOW_SYMLINKS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    
        //$test_array=array();
        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path) + 1);
                $student=$this->studentRepo->find($relativePath);
                /*if($student){
                    $relativePath_rename =$student->name."@".$relativePath;
                    if (!$iterator->isDir()) {
                        $db_path="/storage/Profile/".strval($student->School_id)."/".$relativePath;
                        $relativePath_prev=strtok($relativePath_rename, '/');
                        $real_name=$student->name;
                        if($db_path==$student->profile){
                            array_push($test_array,$relativePath_prev."/".$real_name.".jpg");
                        }else{
                            $counter=1;
                            $check_name=$relativePath_prev."/".$real_name."_".strval($counter).".jpg";
                            while($zip->locateName($check_name) !== false){
                                $counter++;
                                $check_name=$relativePath_prev."/".$real_name."_".strval($counter).".jpg";
                            }
                            array_push($test_array,$check_name);
                        }
                        
                    }else{
                        if ($relativePath_rename !== false) {
                            array_push($test_array,$relativePath_rename);
                        }
                    }
                }*/
                

                $student=$this->studentRepo->find($relativePath);
                if($student){
                    $relativePath_rename =$student->name."@".$relativePath;

                    if (!$iterator->isDir()) {
                        //$zip->addFile($filePath, $relativePath_rename);
                        $db_path="/storage/Profile/".strval($student->School_id)."/".$relativePath;
                        $relativePath_prev=strtok($relativePath_rename, '/');
                        $real_name=$student->name;
                        if($db_path==$student->profile){
                            //array_push($test_array,$relativePath_prev."/".$real_name.".jpg");
                            $zip->addFile($filePath, $relativePath_prev."/".$real_name.".jpg");
                        }else{
                            $counter=1;
                            $check_name=$relativePath_prev."/".$real_name."_".strval($counter).".jpg";
                            while($zip->locateName($check_name) !== false){
                                $counter++;
                                $check_name=$relativePath_prev."/".$real_name."_".strval($counter).".jpg";
                            }
                            //array_push($test_array,$check_name);
                            $zip->addFile($filePath, $check_name);
                        }
                    } else {
                        if ($relativePath_rename !== false) {
                            $zip->addEmptyDir($relativePath_rename);
                        }
                    }
                }
            }
            $iterator->next();
        }
        //return $test_array;
    }

}
