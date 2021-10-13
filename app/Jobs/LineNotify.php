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
    protected $image_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct(school $school, student $student,$image_path)
    {
        $this->school=$school;
        $this->student=$student;
        $this->image_path=$image_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(isset($this->school->LineChannelAccessToken) && isset($this->school->LineChannelSecret))
        if(isset($this->student->parent_line)){
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->school->LineChannelAccessToken);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $this->school->LineChannelSecret]);
            $MessageBuilder = new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder();

            $message="您的孩子".$this->student->name."已經到班囉!";
            $push_build1 = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);

            //$url=str_replace('http://','https://',url($this->image_path));
            $ngrok="https://5c3f-61-220-205-150.ngrok.io";
            $url=str_replace('http://psodf.local',$ngrok,url($this->image_path));
            $push_build2 = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder($url,$url);

            $MessageBuilder->add($push_build1);
            $MessageBuilder->add($push_build2);

            $result=$bot->pushMessage($this->student->parent_line,$MessageBuilder);

        }
    }
}
