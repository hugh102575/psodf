<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Repositories\ClasssRepository;
use App\Repositories\BatchRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\MessageRepository;
use Auth;

class SettingController extends Controller
{
    protected $classsRepo;
    protected $batchRepo;
    protected $studentRepo;
    protected $schoolRepo;

    public function __construct(ClasssRepository $classsRepo,BatchRepository $batchRepo,StudentRepository $studentRepo,SchoolRepository $schoolRepo,MessageRepository $messageRepo)
    {
        $this->middleware(['auth','verified']);
        $this->classsRepo=$classsRepo;
        $this->batchRepo=$batchRepo;
        $this->studentRepo=$studentRepo;
        $this->schoolRepo=$schoolRepo;
        $this->messageRepo=$messageRepo;
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
            return redirect()->route('basic')->with('success_msg', '基本資料已更新！');
        }else{
            return redirect()->route('basic')->with('error_msg', '基本資料更新失敗！');
        }
    }
    public function line_update(Request $request){
        //dd($request->all());
        $school = Auth::user()->school;
        $school->LineID = isset($request['Linedisbtn']) ? null : $request['LineID'];
        $school->LineChannelSecret = isset($request['Linedisbtn']) ? null : $request['LineChannelSecret'];
        $school->LineChannelAccessToken = isset($request['Linedisbtn']) ? null : $request['LineChannelAccessToken'];
        if(isset($request['Linedisbtn'])){
            $school->LineChannelName=null;
            $school->save();
            return redirect()->route('line')->with('success_msg', '已斷開LINE@連接！');
        }else{
            $LineChannelName=$this->get_LineChannelName($request['LineChannelAccessToken']);
            if(isset($LineChannelName)){
                $school->LineChannelName=$LineChannelName;
                $school->save();
                return redirect()->route('line')->with('success_msg', 'LINE@串接成功！');
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
        $result=$this->schoolRepo->update($request->all());
        if($result){
            return redirect()->route('system')->with('success_msg', '系統設定已更新！');
        }else{
            return redirect()->route('system')->with('error_msg', '系統設定更新失敗！');
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

        $stu_array = [];
        $status_a= array();
        $std_name_a=array();
        $total_a=array();
        $processed=array();
        foreach($re as $key => $value)
        {
            if(substr($key,0,7) == "student")
            {
                //array_push($stu_array,$value);

                $st_id=explode("_",$key)[1];
                $st=$this->studentRepo->check_stuid($st_id);
                if($st){
                    $st_name=$st->name;
                }

                $value_d=json_decode($value);
                foreach($value_d as $v){
                    array_push($stu_array,$v);
                    array_push($std_name_a,$st_name);
                }

            }
        }


        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($school->LineChannelAccessToken);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $school->LineChannelSecret]);
        $return =array();
        foreach($stu_array as $key =>$value){
            if(isset($value)){
                $message=$re['Message_Data'];
                $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $result=$bot->pushMessage($value,$push_build);
                $return['status']=$result->getHTTPStatus();
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

}
