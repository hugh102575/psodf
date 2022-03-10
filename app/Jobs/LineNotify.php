<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\student;
use App\Models\school;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LineNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $school;
    protected $student;
    protected $sign;
    protected $image_path;
    protected $created_at;
    protected $setTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct(school $school, student $student,$image_path,$sign,$created_at,$setTime)
    {
        $this->school=$school;
        $this->student=$student;
        $this->sign=$sign;
        $this->image_path=$image_path;
        $this->created_at=$created_at;
        $this->setTime=$setTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mode="notify";
        
        if($mode=="official"){
            if(isset($this->school->LineChannelAccessToken) && isset($this->school->LineChannelSecret))
            if(isset($this->student->parent_line_multi)){
                $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->school->LineChannelAccessToken);
                $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->school->LineChannelSecret]);
                $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

                if($this->sign=="in"){
                    //$message="您的孩子".$this->student->name."已經到班囉!";
                    $msg=$this->school->in_msg;
                    $msg=str_replace("@Name",$this->student->name,$msg);
                    $msg=str_replace("@School",$this->school->School_Name,$msg);
                    $msg=str_replace("@Phone",$this->school->phone,$msg);
                    $message=$msg;
                }else{
                    //$message="您的孩子".$this->student->name."已經下課囉!";
                    $msg=$this->school->out_msg;
                    $msg=str_replace("@Name",$this->student->name,$msg);
                    $msg=str_replace("@School",$this->school->School_Name,$msg);
                    $msg=str_replace("@Phone",$this->school->phone,$msg);
                    $message=$msg;
                }

                $push_build1 = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                if($this->sign=="in"){
                    if(isset($this->setTime)){
                        $timestamp_ = strtotime($this->setTime);
                        $timestamp=date('Y-m-d H:i:s', $timestamp_);
                        $push_build_time = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("簽到時間: \n".$timestamp);
                    }else{
                        $push_build_time = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("簽到時間: \n".$this->created_at);
                    }
                }else{
                    if(isset($this->setTime)){
                        $timestamp_ = strtotime($this->setTime);
                        $timestamp=date('Y-m-d H:i:s', $timestamp_);
                        $push_build_time = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("簽退時間: \n".$timestamp);
                    }else{
                        $push_build_time = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("簽退時間: \n".$this->created_at);
                    }
                }

                $url=str_replace('http://','https://',url($this->image_path));
                //$ngrok="https://ca04-61-220-205-150.ngrok.io";
                //$url=str_replace('http://a.local',$ngrok,url($this->image_path));
                $push_build2 = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($url,$url);

                $MessageBuilder->add($push_build1);
                $MessageBuilder->add($push_build_time);
                $MessageBuilder->add($push_build2);

                $parent_line_multi=json_decode($this->student->parent_line_multi);
                foreach($parent_line_multi as $parent_line){
                    $result=$bot->pushMessage($parent_line,$MessageBuilder);
                }

            }
        }elseif($mode=="notify"){
            if(isset($this->student->parent_line_multi_notify)){
                if($this->sign=="in"){
                    //$message="您的孩子".$this->student->name."已經到班囉!";
                    $msg=$this->school->in_msg;
                    $msg=str_replace("@Name",$this->student->name,$msg);
                    $msg=str_replace("@School",$this->school->School_Name,$msg);
                    $msg=str_replace("@Phone",$this->school->phone,$msg);
                    $message=$msg;
                    if(isset($this->setTime)){
                        $timestamp_ = strtotime($this->setTime);
                        $timestamp=date('Y-m-d H:i:s', $timestamp_);
                        $message=$message."\n\n"."簽到時間: \n".$timestamp;
                    }else{
                        $message=$message."\n\n"."簽到時間: \n".$this->created_at;
                    }
                }else{
                    //$message="您的孩子".$this->student->name."已經下課囉!";
                    $msg=$this->school->out_msg;
                    $msg=str_replace("@Name",$this->student->name,$msg);
                    $msg=str_replace("@School",$this->school->School_Name,$msg);
                    $msg=str_replace("@Phone",$this->school->phone,$msg);
                    $message=$msg;
                    if(isset($this->setTime)){
                        $timestamp_ = strtotime($this->setTime);
                        $timestamp=date('Y-m-d H:i:s', $timestamp_);
                        $message=$message."\n\n"."簽退時間: \n".$timestamp;
                    }else{
                        $message=$message."\n\n"."簽退時間: \n".$this->created_at;
                    }
                }
                $image_url=str_replace('http://','https://',url($this->image_path));
                $send_url="https://notify-api.line.me/api/notify";
                $obj2 =
                        [
                            'message' => $message,
                            'imageThumbnail'=> $image_url,
                            'imageFullsize' =>$image_url
                        ]
                    ;
                

                $parent_line_multi_notify=json_decode($this->student->parent_line_multi_notify);
                foreach($parent_line_multi_notify as $parent_line){
                    $ch2 = curl_init();
                    $authorization = "Authorization: Bearer " . $parent_line;
                    curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data' , $authorization ));
                    curl_setopt($ch2, CURLOPT_POST, 1);
                    curl_setopt($ch2, CURLOPT_URL, $send_url);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch2, CURLOPT_POSTFIELDS, $obj2);
                    $json_result2 = curl_exec($ch2);

                    $resultStatus = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                    curl_close($ch2);
                    if ($resultStatus == 200) {
                        $today=date('Y-m-d');

                        $signin=array();
                            $signin['School_id']=$this->school->id;
                            $signin['Classs_id']=$this->student->classs->id;
                            $signin['Student_id']=$this->student->id;
                            $signin['Classs_Name']=$this->student->classs->Classs_Name;
                            $signin['Student_Name']=$this->student->name;
                            $signin['sign']=$this->sign;
                            $signin['signin_img']=$this->image_path;
                            if(isset($this->setTime)){
                                $timestamp_ = strtotime($this->setTime);
                                $timestamp=date('Y-m-d', $timestamp_);
                                $signin['created_date']=$timestamp;
                            }else{
                                //$signin['created_date']=$today;
                                $timestamp_ = strtotime($this->created_at);
                                $timestamp=date('Y-m-d', $timestamp_);
                                $signin['created_date']=$timestamp;
                            }
                            if(isset($this->setTime)){
                                $timestamp_ = strtotime($this->setTime);
                                $timestamp=date('Y-m-d H:i:s', $timestamp_);
                                $signin['created_at']=$timestamp;
                            }else{
                                $signin['created_at']=$this->created_at;
                            }
                        //$this->signinRepo->store($signin);
                        DB::table('signin')->insert($signin);
                    }
                }
         
            }
        }
    }
}
