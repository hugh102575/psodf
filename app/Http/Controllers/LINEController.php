<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\SchoolRepository;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use App\Models\linekey;

class LINEController extends Controller
{
    protected $schoolRepo;
    protected $studentRepo;
    protected $userRepo;
    public $LineChannelSecret;
    public $LineChannelAccessToken;

    public function __construct(SchoolRepository $schoolRepo,StudentRepository $studentRepo,UserRepository $userRepo)
    {
        $this->schoolRepo=$schoolRepo;
        $this->studentRepo=$studentRepo;
        $this->userRepo=$userRepo;
    }

    public function post(Request $request, Response $response,$api_token){



        //$school=$this->schoolRepo->find($id);
        //$owner=$this->userRepo->owner($id);
        $owner=$this->userRepo->api_token_owner($api_token);
        $school=$this->schoolRepo->find($owner->School_id);

        $this->LineChannelSecret = $school->LineChannelSecret;
        $this->LineChannelAccessToken = $school->LineChannelAccessToken;

        $body      = file_get_contents('php://input');
        file_put_contents('php://stderr', 'Body: '.$body);

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->LineChannelAccessToken);
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->LineChannelSecret]);
        $data = json_decode($body, true);
        $userId=$data['events'][0]['source']['userId'];

        foreach ($data['events'] as $event){
            $type= $event['type'];
            if($type=="follow"){
                /*$message="家長您好，\n請輸入小朋友的學號";
                $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $result=$bot->pushMessage($userId,$push_build);*/
                $this->default_template($school,$bot,$userId,null);
            }
            elseif($type=="postback"){
                $postback_data=$event['postback']['data'];
                if($postback_data=="bind_student"){
                    $message="家長您好，\n請輸入小朋友的學號"."\n"."(輸入數字)";
                    $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $rp_result=$bot->replyMessage($event['replyToken'],$push_build);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        //$result=$bot->pushMessage($userId,$push_build);
                    }
                    //$result=$bot->pushMessage($userId,$push_build);
                }else if($postback_data=="contact"){
                    //$message="$ "."<".$school->School_Name.">"."\n"."聯絡人: ".$owner->name."\n"."聯絡電話: ".$school->phone."\n"."聯絡地址: \n".$school->address;
                    $message="$ "."<".$school->School_Name.">"."\n"."聯絡人: ".$school->admin."\n"."聯絡電話: ".$school->phone."\n"."聯絡地址: \n".$school->address;
                    $emoji1 = new \LINE\LINEBot\MessageBuilder\Text\EmojiBuilder(0, '5ac21542031a6752fb806d55', '119');
                    //$emoji2 = new \LINE\LINEBot\MessageBuilder\Text\EmojiBuilder(1, '5ac21542031a6752fb806d55', '119');
                    $emojiText = new \LINE\LINEBot\MessageBuilder\Text\EmojiTextBuilder($message, $emoji1);
                    $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emojiText);
                    //$push_build2 = new \LINE\LINEBot\MessageBuilder\LocationMessageBuilder($school->School_Name,$school->address,25.04395588388903, 121.52203109668106);
                    $rp_result=$bot->replyMessage($event['replyToken'],$push_build);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        //$result=$bot->pushMessage($userId,$push_build);
                    }
                    //$result=$bot->pushMessage($userId,$push_build);
                }
                else if($postback_data=="bind_student2"){
                    $encode=str_replace('/','_',base64_encode($userId));
                    $url=url("bind"."/".$school->id."/".$encode);
                    $message="親愛的家長您好，\n請前往下列網址進行綁定。\n".$url;
                    $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $rp_result=$bot->replyMessage($event['replyToken'],$push_build);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        //$result=$bot->pushMessage($userId,$push_build);
                    }
                }
                else if($postback_data=="main_menu"){
                    $this->default_template($school,$bot,$userId,$event['replyToken']);
                }
            }else{
                $this->default_template($school,$bot,$userId,$event['replyToken']);
                /*$message = $event['message'];
                $userMessage=$message['text'];
                $student=$this->studentRepo->check_stuid($userMessage);
                if($student){
                    //$add_line=$this->studentRepo->add_parent_line($student->id,$userId);
                    $add_line=$this->studentRepo->add_parent_line2($student,$userId);
                    if($add_line){
                        $message="設定成功!\n".$student->name."的家長您好，"."之後小朋友到班時，本程式會自動通知您";
                    }else{
                        $message="謝謝，".$student->name."的家長，\n"."您之前已經設定成功囉";
                    }
                    $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                    $reply_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $MessageBuilder->add($reply_build);
                    $rp_result=$bot->replyMessage($event['replyToken'],$MessageBuilder);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        $result=$bot->pushMessage($userId,$reply_build);
                    }
                }else{
                    if(is_numeric($userMessage)){
                        $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                    //$message="家長您好，\n請輸入小朋友的學號";
                    $message="查無學生資料，\n請檢查輸入是否正確";
                    $reply_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $MessageBuilder->add($reply_build);
                    $rp_result=$bot->replyMessage($event['replyToken'],$MessageBuilder);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        $result=$bot->pushMessage($userId,$reply_build);
                    }
                    }else{
                        $this->default_template($bot,$userId);
                    }

                }*/
            }
        }

    }
    public function default_template($school,$bot,$userId,$rp_token){
        $actions = array();
        $url=url("bind"."/".$school->id."/".$userId);
        $url2=url("supervise"."/".$school->id."/".$userId);
        $thumb_nail=url('img/dexway-classroom-companion-ingles-uk.jpg');
        $per_btn_build=new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("綁定孩子資料",$url);
        //$per_btn_build=new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("綁定學生資料",'bind_student2');
        array_push($actions,$per_btn_build);


        $per_btn_build3=new \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder("查詢孩子簽到退",$url2);
        //$per_btn_build=new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("綁定學生資料",'bind_student2');
        array_push($actions,$per_btn_build3);


        $per_btn_build2=new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("聯絡安親班",'contact');
        array_push($actions,$per_btn_build2);
        //$btn_build = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder(null,$school->School_Name."\n"."家長您好，請選擇操作選項",null,$actions);
        $btn_build = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder($school->School_Name,"親愛的家長您好，\n請選擇操作選項。",$thumb_nail,$actions);
        $MessageBuild = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder("按鈕訊息回覆", $btn_build);
        if($rp_token==null){
            //$result=$bot->pushMessage($userId,$MessageBuild);
        }else{
            $rp_result=$bot->replyMessage($rp_token,$MessageBuild);
            if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                //$result=$bot->pushMessage($userId,$MessageBuild);
            }
        }
    }
    /*public function add_rich_menu($school,$userId,$access_token){
        $authorization = "Authorization: Bearer " . $access_token;
        $url_1 = "https://api.line.me/v2/bot/richmenu";
        $bind_url=url("bind"."/".$school->id."/".$userId);
        $rich_menu_object=
        '{
            "size": {
              "width": 2500,
              "height": 843
            },
            "selected": false,
            "name": "my_richmenu",
            "chatBarText": "操作選項",
            "areas": [
              {
                "bounds": {
                  "x": 0,
                  "y": 0,
                  "width": 1250,
                  "height": 843
                },
                "action": {
                  "type": "uri",
                  "label": "綁定學生資料",
                  "uri": '.$bind_url.'
                }
              },
              {
                "bounds": {
                  "x": 1250,
                  "y": 0,
                  "width": 1250,
                  "height": 843
                },
                "action": {
                  "type": "postback",
                  "label": "聯絡安親班",
                  "data": "contact"
                }
              }
           ]
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_URL, $url_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($rich_menu_object));
        $json_result = curl_exec($ch);
        $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resultStatus == 200) {
            $result=json_decode($json_result,true);
	        $richMenuId=$result['richMenuId'];
        }else{
            $result=null;
        }
        curl_close($ch);
    }*/
}



