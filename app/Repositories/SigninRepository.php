<?php

namespace App\Repositories;

use App\Models\signin;
use Illuminate\Support\Facades\Auth;

class SigninRepository
{

    public function store($data){
        return  signin::create($data);
    }

    public function get_signin($classs_id,$date){
        return  signin::where('School_id',Auth::user()->School_id)->where('Classs_id',$classs_id)->where('created_date',$date)->get();
    }

    public function find_record($id,$date){
        return  signin::where('Student_id',$id)->where('created_date',$date)->first();
    }

    public function parent_supervise($school_id,$student){
        $my_child_sign=array();
        $my_child_id=array();
        foreach($student as $st){
            array_push($my_child_id,$st->id);
        }
        $signin=signin::where('School_id',$school_id)->get()->reverse()->values();
        if(count($signin)!=0){
            foreach($signin as $sn){
                if(in_array($sn->Student_id,$my_child_id)){
                    array_push($my_child_sign,$sn);
                }
            }
        }

        return $my_child_sign;
     
    }

    public function getmultidata($date_array){
        foreach($date_array as $index => $value) {
            $signin=signin::where('created_date', '=', $value)->where('School_id',Auth::user()->School_id)->where('sign','in')->get();
            $signout=signin::where('created_date', '=', $value)->where('School_id',Auth::user()->School_id)->where('sign','out')->get();
            $date_array[$index]=array(
                    'daily'=>$value,
                    'FbBot_use'=>count($signin),
                    'LineBot_use'=>count($signout),
                );
        }
        return $date_array;
    }

}
