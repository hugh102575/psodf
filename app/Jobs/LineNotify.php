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

class LineNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $school;
    protected $student;
    protected $sign;
    protected $image_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct(school $school, student $student,$image_path,$sign)
    {
        $this->school=$school;
        $this->student=$student;
        $this->sign=$sign;
        $this->image_path=$image_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*if(isset($this->school->LineChannelAccessToken) && isset($this->school->LineChannelSecret))
        if(isset($this->student->parent_line)){
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->school->LineChannelAccessToken);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->school->LineChannelSecret]);
            $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

            if($this->sign=="in"){
                $message="[簽到] 您的孩子".$this->student->name."已經到班囉!";
            }else{
                $message="[簽退] 您的孩子".$this->student->name."已經下課囉!";
            }

            $push_build1 = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);

            //$url=str_replace('http://','https://',url($this->image_path));
            $ngrok="https://1d7c-111-241-75-55.ngrok.io";
            $url=str_replace('http://psodf.local',$ngrok,url($this->image_path));
            $push_build2 = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($url,$url);

            $MessageBuilder->add($push_build1);
            $MessageBuilder->add($push_build2);

            $result=$bot->pushMessage($this->student->parent_line,$MessageBuilder);

        }*/

        if(isset($this->school->LineChannelAccessToken) && isset($this->school->LineChannelSecret))
        if(isset($this->student->parent_line_multi)){
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->school->LineChannelAccessToken);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->school->LineChannelSecret]);
            $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

            if($this->sign=="in"){
                $message="[簽到] 您的孩子".$this->student->name."已經到班囉!";
            }else{
                $message="[簽退] 您的孩子".$this->student->name."已經下課囉!";
            }

            $push_build1 = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);

            //$url=str_replace('http://','https://',url($this->image_path));
            $ngrok="https://7862-220-132-38-167.ngrok.io";
            $url=str_replace('http://psodf.local',$ngrok,url($this->image_path));
            $push_build2 = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($url,$url);

            $MessageBuilder->add($push_build1);
            $MessageBuilder->add($push_build2);

            $parent_line_multi=json_decode($this->student->parent_line_multi);
            foreach($parent_line_multi as $parent_line){
                $result=$bot->pushMessage($parent_line,$MessageBuilder);
            }

        }
    }
}
