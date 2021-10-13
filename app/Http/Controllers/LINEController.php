<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\SchoolRepository;
use App\Repositories\StudentRepository;
use App\Models\linekey;

class LINEController extends Controller
{
    protected $schoolRepo;
    protected $studentRepo;
    public $LineChannelSecret;
    public $LineChannelAccessToken;

    public function __construct(SchoolRepository $schoolRepo,StudentRepository $studentRepo)
    {
        $this->schoolRepo=$schoolRepo;
        $this->studentRepo=$studentRepo;
    }

    public function post(Request $request, Response $response,$id){

        $school=$this->schoolRepo->find($id);

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
                $message="家長您好，\n請輸入小朋友的學號";
                $push_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                $result=$bot->pushMessage($userId,$push_build);
            }else{
                $message = $event['message'];
                $userMessage=$message['text'];
                $student=$this->studentRepo->check_stuid($userMessage);
                if($student){
                    $add_line=$this->studentRepo->add_parent_line($student->id,$userId);
                    if($add_line){
                        $message="設定成功!\n".$student->name."的家長您好，"."之後小朋友到班時，本程式會自動通知您";
                    }else{
                        $message="謝謝，".$student->name."的家長，\n"."您已經設定成功囉";
                    }
                    $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                    $reply_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $MessageBuilder->add($reply_build);
                    $rp_result=$bot->replyMessage($event['replyToken'],$MessageBuilder);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        $result=$bot->pushMessage($userId,$reply_build);
                    }
                }else{
                    $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                    $message="家長您好，\n請輸入小朋友的學號";
                    $reply_build = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
                    $MessageBuilder->add($reply_build);
                    $rp_result=$bot->replyMessage($event['replyToken'],$MessageBuilder);
                    if($rp_result->getHTTPStatus()!=200 && $rp_result->getHTTPStatus()!="200"){
                        $result=$bot->pushMessage($userId,$reply_build);
                    }
                }
            }
        }

    }
}
