<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\role;
use App\Models\School;

class SuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        /*$user = Auth::user();
        if($user->api_token==null){
            $user->api_token = Str::random(60);
            $user->save();
        }*/
        $user = Auth::user();
        if($user->api_token==null){
            $api_token=Str::random(60);
            while(User::where('api_token',$api_token)->exists()) {
                $api_token=Str::random(60);
            }
            $user->api_token = $api_token;
            $user->save();
        }
        $school = Auth::user()->school;
        /*if($school->PID==null){
            $PID=strval("s").strval(rand(10000,99999));
            while(School::where('PID',$PID)->exists()) {
                $PID=strval("s").strval(rand(10000,99999));
            }
            $school->PID=$PID;
            $school->save();
        }*/
        if($school->in_msg==null || $school->out_msg==null){
            $school->in_msg="您的孩子@Name已經到班囉!";
            $school->out_msg="您的孩子@Name已經下課囉!";
            $school->save();
        }

    }
}
