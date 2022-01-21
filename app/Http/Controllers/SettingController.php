<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\ClasssRepository;
use App\Repositories\BatchRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Auth;
use Validator;

class SettingController extends Controller
{
    protected $classsRepo;
    protected $batchRepo;
    protected $studentRepo;
    protected $schoolRepo;
    protected $userRepo;
    protected $roleRepo;

    public function __construct(ClasssRepository $classsRepo,BatchRepository $batchRepo,StudentRepository $studentRepo,SchoolRepository $schoolRepo,MessageRepository $messageRepo,UserRepository $userRepo, RoleRepository $roleRepo)
    {
        $this->middleware(['auth','verified']);
        $this->classsRepo=$classsRepo;
        $this->batchRepo=$batchRepo;
        $this->studentRepo=$studentRepo;
        $this->schoolRepo=$schoolRepo;
        $this->messageRepo=$messageRepo;
        $this->userRepo=$userRepo;
        $this->roleRepo=$roleRepo;
    }

    public function classs_store(Request $request){
        $result=$this->classsRepo->store($request->all());
        if($result){
            return redirect()->route('classs.classs')->with('success_msg', '班級已創建！');
        }else{
            return redirect()->route('classs.classs')->with('error_msg', '班級創建失敗！');
        }
    }
    public function classs_update(Request $request){
        $id=$request['classs_update_id'];
        $result = $this->classsRepo->update($request->all(),$id);
        if($result){
            return redirect()->route('classs.classs')->with('success_msg', '班級已編輯！');
        }else{
            return redirect()->route('classs.classs')->with('error_msg', '班級編輯失敗！');
        }
    }
    /*public function classs_delete(Request $request){
        if (Hash::check($request['password'], Auth::user()->password)){
            $id=$request['confirm_delete_id'];
            $result=$this->classsRepo->delete($id);
        }else{
            $result=false;
        }

        if($result){
            return redirect()->route('classs.classs')->with('success_msg', '班級已刪除！');
        }else{
            return redirect()->route('classs.classs')->with('error_msg', '班級刪除失敗！');
        }
    }*/
    public function classs_delete(Request $request){
        $id=$request['id'];
        $student=$this->classsRepo->find($id)->student;
        if(count($student)==0){
            $result=$this->classsRepo->delete($id);
            if($result){
                $return['result']="success";
                $return['msg']="班級已刪除！";
            }else{
                $return['result']="error";
                $return['msg']="班級刪除失敗！";
            }

        }else{
            $return['result']="error";
            $return['msg']="班級刪除失敗！此梯次含有學生";
        }
        return json_encode($return);
    }
    public function student_update(Request $request,$id){

       $classs=$this->classsRepo->find($id);
       $classs_id=$classs->id;
       $count=1;
       if($request['Student_List']!=null){
            if($request['Student_List_old']!=null){
                foreach($request['Student_List_old'] as $student_old){
                    $old_id=$student_old['id'];
                    $found=false;
                    foreach($request['Student_List'] as $student){
                        if($student['id']==$old_id){
                            $found=true;
                            break;
                        }
                    }
                    if(!$found){
                        $this->studentRepo->delete($old_id);
                    }
                }
            }

            foreach($request['Student_List'] as $student){
                if($student['name']!=null){
                    $classs_id=(isset($student['Classs_id'])) ? $student['Classs_id'] : $classs_id;
                    if($student['id']==null){
                        $this->studentRepo->store($student,$classs,$classs_id,$count);
                    }else{
                        $this->studentRepo->update($student,$classs_id,$count,$student['id']);
                    }
                    $count++;
                }
            }
       }else{
            foreach($request['Student_List_old'] as $student_old){
                $old_id=$student_old['id'];
                $this->studentRepo->delete($old_id);
            }
       }

        //$result = $this->classsRepo->update($request->all(),$id);
        $result=true;
        if($result){
            $return['result']="success";
            $return['msg']="學生名單已編輯！";
            $return['id']=$id;
        }else{
            $return['result']="error";
            $return['msg']="學生名單編輯失敗！";
            $return['id']=$id;
        }
        return json_encode($return);

    }
    public function student_search(Request $request){
        $result = $this->studentRepo->search_student($request['student_name']);
        return json_encode($result);
    }
    public function batch_store(Request $request){
        $result=$this->batchRepo->store($request->all());
        if($result){
            return redirect()->route('batch')->with('success_msg', '梯次已創建！');
        }else{
            return redirect()->route('batch')->with('error_msg', '梯次創建失敗！');
        }
    }
    public function batch_update(Request $request){
        $id=$request['batch_update_id'];
        $result=$this->batchRepo->update($request->all(),$id);
        if($result){
            return redirect()->route('batch')->with('success_msg', '梯次已編輯！');
        }else{
            return redirect()->route('batch')->with('error_msg', '梯次編輯失敗！');
        }
    }
    public function batch_delete(Request $request){
        $id=$request['id'];
        $classs=$this->batchRepo->find($id)->classs;
        if(count($classs)==0){
            $result=$this->batchRepo->delete($id);
            if($result){
                $return['result']="success";
                $return['msg']="梯次已刪除！";
            }else{
                $return['result']="error";
                $return['msg']="梯次刪除失敗！";
            }

        }else{
            $return['result']="error";
            $return['msg']="梯次刪除失敗！此梯次含有班級";
        }
        return json_encode($return);

    }
    public function perstudent_update(Request $request,$id){
        //return json_encode($request->all());
       $result=$this->studentRepo->single_update($request['student'],$id);
       if($result){
            $return['result']="success";
            $return['msg']="學生資料已更新！";
        }else{
            $return['result']="error";
            $return['msg']="學生資料更新失敗！";
        }
        return json_encode($return);
    }
    public function perstudent_delete($id){
        $result=$this->studentRepo->delete($id);
       if($result){
            $return['result']="success";
            $return['msg']="學生資料已刪除！";
        }else{
            $return['result']="error";
            $return['msg']="學生資料刪除失敗！";
        }
        return json_encode($return);
    }
    public function basic_update(Request $request){
        $result=$this->schoolRepo->update($request->all());
        if($result){
            return redirect()->route('basic')->with('success_msg', '基本設定已更新！');
        }else{
            return redirect()->route('basic')->with('error_msg', '基本設定更新失敗！');
        }
    }
    public function self_profile_update(Request $request){
        //dd($request->all());
        if($request->input('button')=="m1"){
            $result=$this->userRepo->update($request->all());
            if($result){
                return redirect()->route('self_profile')->with('success_msg', '個人姓名已更新！');
            }else{
                return redirect()->route('self_profile')->with('error_msg', '個人姓名更新失敗！');
            }
        }elseif($request->input('button')=="m2"){
            
            if(!Hash::check ($request->input('profilePW_old'),Auth::user()->password)){
                return redirect()->route('self_profile')->with('error_msg', '使用者密碼輸入錯誤!');
            }elseif($request->input('profilePW_new')!=$request->input('profilePW_new2')){
                return redirect()->route('self_profile')->with('error_msg', '新密碼確認不一致!');
            }elseif($request->input('profilePW_new')==$request->input('profilePW_old')){
                return redirect()->route('self_profile')->with('error_msg', '新舊密碼相同!');
            }else{
                $validator = Validator::make($request->all(),[
                    'profilePW_new' => 'required|string|min:8',
                ]);
                if ($validator->fails()) {
                    return redirect()->route('self_profile')->with('error_msg', '新密碼太短，至少8個字元!');
                }else{
                    $result=$this->userRepo->update($request->all());
                    if($result){
                        Auth::logout();
                        return redirect()->route('login')->with('login_success_msg', '密碼已更新，請重新登入!');
                        //return redirect()->route('self_profile')->with('success_msg', '密碼已更新!');
                    }else{
                        return redirect()->route('self_profile')->with('error_msg', '密碼更新失敗!');
                    }
                }
            }
        }
       
    }

    public function role_create_post(Request $request){
        if($this->roleRepo->check_name($request->input('Role_Name'))){
            return redirect()->route('role')->with('error_msg', '新增失敗，該角色名稱已存在！');
        }else{
            if(isset(request()->authority))
                $roles = $this->roleRepo->create(request()->only('Role_Name', 'Role_Desc', 'authority'));
            else
                $roles = $this->roleRepo->create(request()->only('Role_Name', 'Role_Desc'));

            if (!$roles) {
                return redirect()->route('role')->with('error_msg', '角色新增失敗！');
            }
        }
    
        return redirect()->route('role')->with('success_msg', '角色新增成功！');
    }
    public function role_edit_post(Request $request,$RoleID){
        if($this->roleRepo->check_name2($request->input('Role_Name'),$RoleID)){
            return redirect()->route('role')->with('error_msg', '編輯失敗，該角色名稱已存在！');
        }else{
            if(isset(request()->authority))
                $roles = $this->roleRepo->update(request()->only('Role_Name', 'Role_Desc', 'authority'),$RoleID);
            else
                $roles = $this->roleRepo->update(request()->only('Role_Name', 'Role_Desc'),$RoleID);

            if (!$roles) {
                return redirect()->route('role')->with('error_msg', '角色編輯失敗！');
            }
        }

        return redirect()->route('role')->with('success_msg', '角色編輯成功！');
    }
    public function role_delete_post(Request $request,$RoleID){
        $result=$this->roleRepo->delete($RoleID);

        if($result=="role_conflict"){
            return redirect()->route('role')->with('error_msg', '角色刪除失敗，此角色正在使用中！');
        }


        if($result){
            return redirect()->route('role')->with('success_msg', '角色已刪除！');
        }else{
            return redirect()->route('role')->with('error_msg', '角色刪除失敗！');
        }
    }
    public function account_create_post(Request $request){
        //dd($request->all());
        $messages = [
            'required'    => '此欄位為必填',
            'email.unique'    => '此信箱已有使用者註冊',
            'password.regex' => '使用者密碼不符合規範',
            'password.confirmed' => '密碼確認不相符',
            'max' => '此欄位限制最大字數為:max',
            'min' => '此欄位限制最少字數為:min',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'RoleID' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('account.create')
                ->withErrors($validator)
                ->withInput();
        }

        $account = $this->userRepo->create(request()->only('name', 'email', 'password', 'RoleID'));
        if (!$account) {
            return redirect()->route('account')->with('error_msg', '帳號新增失敗！');
        }

        return redirect()->route('account')->with('success_msg', '帳號新增成功！');
    }
    public function account_edit_post(Request $request,$id){
        //dd($request->all());
        $check_only_admin=$this->userRepo->check_only_admin($id, request()->RoleID);
        if($check_only_admin != 'admin_only_me_failed' && $check_only_admin != 'no_admin'){
            $result = $this->userRepo->update_account($id, request()->only('name', 'RoleID'));
            if($result){
                return redirect()->route('account')->with('success_msg', '帳號資料已更新！');
            }else{
                return redirect()->route('account')->with('error_msg', '帳號更新失敗！');
            }
        }else{
            return redirect()->route('account')->with('error_msg', '帳號更新失敗，至少需要一名管理員！');
        }
        
    }

    public function account_delete_post(Request $request,$id){
        //dd($request->all());
        $account=$this->userRepo->find($id);
        $role_name=$account->role->Role_Name;
        if($role_name=="安親班管理員"){
            return redirect()->route('account')->with('error_msg', '刪除失敗!無法刪除管理員的帳號，如需刪除，請先指派其他角色');
        }else{
            $result=$this->userRepo->delete($id);
            if($result){
                return redirect()->route('account')->with('success_msg', '帳號已刪除！');
            }else{
                return redirect()->route('account')->with('error_msg', '帳號刪除失敗！');
            }
        }
    }

    public function change_active(Request $request,$id){
        //echo $id;
        //dd($request->all());
        $account=$this->userRepo->find($id);
        $role_name=$account->role->Role_Name;

        if($request->input('current_status')==1){
            $new_status=0;
        }elseif($request->input('current_status')==0){
            $new_status=1;
        }
        
        if($role_name=="安親班管理員" && $new_status==0){
            return redirect()->route('account')->with('error_msg', '停用失敗!無法停用管理員的帳號，如需停用，請先指派其他角色');
        }else{
            $result=$this->userRepo->change_active($id,$new_status);
            if($result[1]==1){
                if($result[0]){
                    return redirect()->route('account')->with('success_msg', '帳號已啟用！');
                }else{
                    return redirect()->route('account')->with('error_msg', '帳號啟用失敗！');
                }
            }elseif($result[1]==0){
                if($result[0]){
                    return redirect()->route('account')->with('success_msg', '帳號已停用！');
                }else{
                    return redirect()->route('account')->with('error_msg', '帳號停用失敗！');
                }
            }
        }

    }
    
    public function line_update(Request $request){
        //dd($request->all());
        $school = Auth::user()->school;
        $LineChannelAccessToken_db=$school->LineChannelAccessToken;

        $school->LineID = isset($request['Linedisbtn']) ? null : $request['LineID'];
        $school->LineChannelSecret = isset($request['Linedisbtn']) ? null : $request['LineChannelSecret'];
        $school->LineChannelAccessToken = isset($request['Linedisbtn']) ? null : $request['LineChannelAccessToken'];
        if(isset($request['Linedisbtn'])){
            $school->LineChannelName=null;
            $school->save();
            //if($school->id==2){
                $test_result='已斷開LINE@連接！';
                $rich_menu_result=$this->del_rich_menu($school,$LineChannelAccessToken_db);
                return redirect()->route('line')->with('success_msg', $test_result);
            //}else{
                //return redirect()->route('line')->with('success_msg', '已斷開LINE@連接！');
            //}
            
        }else{
            $LineChannelName=$this->get_LineChannelName($request['LineChannelAccessToken']);
            if(isset($LineChannelName)){
                
                $school->LineChannelName=$LineChannelName;
                $school->save();
                //if($school->id==2){
                    $test_result='LINE@串接成功！';
                    $rich_menu_result=$this->add_rich_menu($school,$request['LineChannelAccessToken']);
                    return redirect()->route('line')->with('success_msg', $test_result);
                //}else{
                    //return redirect()->route('line')->with('success_msg', 'LINE@串接成功！');
                //}
                
            }else{
                return redirect()->route('line')->with('error_msg', '輸入資料有誤，查無資料！');
            }
        }
    }
    public function get_LineChannelName($access_token){
        $url = "https://api.line.me/v2/bot/info";
        $ch = curl_init();
        $authorization = "Authorization: Bearer " . $access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $json_result = curl_exec($ch);
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus == 200) {
            $result=json_decode($json_result,true);
	        $result=$result['displayName'];
        }else{
            $result=null;
        }
        curl_close($ch);
        return $result;
    }
    public function system_update(Request $request){
        $result=$this->schoolRepo->sys_update($request->all());
        if($result){
            return redirect()->route('system')->with('success_msg', '進階設定已更新！');
        }else{
            return redirect()->route('system')->with('error_msg', '進階設定更新失敗！');
        }
    }
    public function message_store(Request $request){
        $result=$this->messageRepo->store($request->all());
        if($result){
            return redirect()->route('message')->with('success_msg', '訊息範本已創建！');
        }else{
            return redirect()->route('message')->with('error_msg', '訊息範本創建失敗！');
        }
    }
    public function message_update(Request $request){
        $id=$request['message_update_id'];
        $result = $this->messageRepo->update($request->all(),$id);
        if($result){
            return redirect()->route('message')->with('success_msg', '訊息範本已編輯！');
        }else{
            return redirect()->route('message')->with('error_msg', '訊息範本編輯失敗！');
        }
    }
    public function message_delete(Request $request){
        $id=$request['id'];
        $result=$this->messageRepo->delete($id);
        if($result){
            $return['result']="success";
            $return['msg']="範本已刪除！";
        }else{
            $return['result']="error";
            $return['msg']="範本刪除失敗！";
        }

        return json_encode($return);
    }
    public function message_send(Request $request){

        $school=Auth::user()->school;

        $re = $request->all();

        $stu_array = array();
        $status_a= array();
        $std_name_a=array();
        $total_a=array();
        $processed=array();
        $stID_array = array();
        foreach($re as $key => $value)
        {
            if(substr($key,0,7) == "student")
            {
                //array_push($stu_array,$value);

                $st_id=explode("_",$key)[1];
                $st=$this->studentRepo->check_stuid($st_id,$school->id);
                if($st){
                    $st_name=$st->name;
                    $stID=$st->id;
                
                    $value_d=json_decode($value);
                    foreach($value_d as $v){
                        array_push($stu_array,$v);
                        array_push($std_name_a,$st_name);
                        array_push($stID_array,$stID);
                    }
                }

            }
        }


        
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($school->LineChannelAccessToken);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $school->LineChannelSecret]);
        $return =array();
        foreach($stu_array as $key =>$value){
            if(isset($value)){
                $STU=$st=$this->studentRepo->find($stID_array[$key]);

                $msg=$re['Message_Data'];
                if($STU){
                $msg=str_replace("@Name",$STU->name,$msg);
                }
                $msg=str_replace("@School",$school->School_Name,$msg);
                $msg=str_replace("@Phone",$school->phone,$msg);
                $message=$msg;

                $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $result=$bot->pushMessage($value,$push_build);
                $return['status']=$result->getHTTPStatus();
                //$return['status']=200;
                //return redirect()->route('message')->with('success_msg', '訊息已發送！');
            }else{
                $return['status']=404;
                //return redirect()->route('message')->with('error_msg', '訊息發送失敗！');
            }
            array_push($status_a,$return['status']);
        }

        foreach($std_name_a as $key =>$value){
            $st_name=$value;
            $st_merge=array("name"=>$st_name,"successed_count"=>0,"failed_count"=>0);
            $psed=false;
            foreach($std_name_a as $key2 =>$value2){
                if($st_name==$value2){
                    if (!in_array($st_name, $processed)){
                        $status=$status_a[$key2];
                        if($status==200){
                            $st_merge["successed_count"]=$st_merge["successed_count"]+1;
                        }else{
                            $st_merge["failed_count"]=$st_merge["failed_count"]+1;
                        }
                    }else{
                        $psed=true;
                        break;
                    }
                }
            }
            if(!$psed){
                array_push($total_a,$st_merge);
                array_push($processed,$st_name);
            }
        }

        //dd($total_a);
        $result_string_1="發送成功: ";
        $result_string_2="發送失敗: ";
        $s_count=0;
        $f_count=0;
        foreach($total_a as $key =>$value){
            $st_name=$value['name'];
            $sc=$value['successed_count'];
            $fc=$value['failed_count'];
            if($sc>0){
                $str=$st_name."的家長"."(".strval($sc)."則)".", ";
                $result_string_1=$result_string_1.$str;
                $s_count++;
            }
            if($fc>0){
                $str=$st_name."的家長"."(".strval($fc)."則)".", ";
                $result_string_2=$result_string_2.$str;
                $f_count++;
            }
        }
        if($s_count>0 && $f_count==0){
            return redirect()->route('message')->with('success_msg', $result_string_1);
        }else if($f_count>0 && $s_count==0){
            return redirect()->route('message')->with('error_msg', $result_string_2);
        }else{
            //return redirect()->route('message')->with('success_msg', $result_string_1."， ".$result_string_2);
            return redirect()->route('message')->with('success_msg', $result_string_1)->with('error_msg', $result_string_2);
        }
        

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
            //$result=json_encode($richmenus_a);
        }else{
            $result="http_error_1";
        }

        $resultStatus_a=array();
        if(count($richmenus_a)!=0){
            foreach($richmenus_a as $r_id){
                $url_2 = "https://api.line.me/v2/bot/richmenu/".$r_id;
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_URL, $url_2);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $json_result = curl_exec($ch);
                $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                array_push($resultStatus_a,$resultStatus);
            }
            curl_close($ch);
            
            foreach($resultStatus_a as $rs){
                if($rs!=200){
                    $result="http_error_2";
                    break;
                }else{
                    $result="rm_all_richmenus";
                }
            }
            
        }else{
            curl_close($ch);
        }
        return $result;
    }
    public function add_rich_menu($school,$access_token){
        $authorization = "Authorization: Bearer " . $access_token;

        $richMenuId=null;
        //$userId="1234";
        $url_1 = "https://api.line.me/v2/bot/richmenu";
        //$bind_url=url("bind"."/".$school->id."/".$userId);
        /*$rich_menu_obj =
                        [
                            'size' => ['width' => 2500 , 'height' => 843],
                            'selected' => false,
                            'name' =>  'my_richmenu',
                            'chatBarText' => '操作選項',
                            'areas' => [
                                [
                                    'bounds' => [
                                        'x' => 0,
                                        'y' => 0,
                                        'width' => 1250,
                                        'height' =>843
                                    ],
                

                                    'action'=>[
                                        'type' => 'postback',
                                        'label' => '綁定學生資料',
                                        'data' => 'bind_student2'
                                    ]
                                ],
                                [
                                    'bounds' => [
                                        'x' => 1250,
                                        'y' => 0,
                                        'width' => 1250,
                                        'height' =>843
                                    ],
                                    'action'=>[
                                        'type' => 'postback',
                                        'label' => '聯絡安親班',
                                        'data' => 'contact'
                                    ]
                                ],

                            ]
                        ]
                    ;*/
                    $rich_menu_obj =
                    [
                        'size' => ['width' => 800 , 'height' => 270],
                        'selected' => false,
                        'name' =>  'my_richmenu',
                        'chatBarText' => '主選單',
                        'areas' => [
                            [
                                'bounds' => [
                                    'x' => 0,
                                    'y' => 0,
                                    'width' => 400,
                                    'height' =>270
                                ],
            

                                'action'=>[
                                    'type' => 'postback',
                                    'label' => '主選單',
                                    'data' => 'main_menu'
                                ]
                            ],
                            [
                                    'bounds' => [
                                        'x' => 400,
                                        'y' => 0,
                                        'width' => 400,
                                        'height' =>270
                                    ],
                
    
                                    'action'=>[
                                        'type' => 'postback',
                                        'label' => '聯絡安親班',
                                        'data' => 'contact'
                                    ]
                            ]

                        ]
                    ]
                ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_URL, $url_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rich_menu_obj));
        $json_result = curl_exec($ch);
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus == 200) {
            $result=json_decode($json_result,true);
	        $richMenuId=$result['richMenuId'];
            $result=$richMenuId;
        }else{
            $result="http_error_1";
        }
        //curl_close($ch);

        //$richMenuId="richmenu-44974ac3bce7f6f76fa7a563b57f0969";
        if(isset($richMenuId)){
            $image_path=url('img/rich_menu_main2.png');
            $url_2 = "https://api-data.line.me/v2/bot/richmenu/".$richMenuId."/content";
            //$ch_2 = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: image/png' , $authorization ));
            curl_setopt($ch, CURLOPT_URL, $url_2);
            curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($image_path));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json_result = curl_exec($ch);
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($resultStatus == 200) {
                $result="http_ok_2";
            }else{
                $result="http_error_2";
            }
            //curl_close($ch);

            if($result=="http_ok_2"){
                $url_3 = "https://api.line.me/v2/bot/user/all/richmenu/".$richMenuId;
                //$ch_3 = curl_init();
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
                curl_setopt($ch, CURLOPT_URL, $url_3);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $json_result = curl_exec($ch);
                $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($resultStatus == 200) {
                    $result="http_ok_3";
                }else{
                    $result="http_error_3";
                }
                curl_close($ch);
            }else{
                curl_close($ch);
            }
        }else{
            curl_close($ch);
        }




        return $result;
    }

}
