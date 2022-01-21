<?php

namespace App\Repositories;

use App\Models\School;
use App\Models\User;
use Auth;

class SchoolRepository
{

    public function find($id){
        return School::find($id);
    }
    public function update(array $data){
        $id=Auth::user()->School_id;
        $now = date('Y-m-d H:i:s');
        //if(isset($data['manager_phone'])||isset($data['manager_name'])){
            $data['phone']=$data['manager_phone'];
            $data['address']=$data['manager_address'];
            $data['admin']=$data['manager_name'];
            //$user=User::where('School_id',$id)->first();
            //$user->update(array('name' => $data['manager_name']));
        //}
        $data['updated_at']=$now;
        $school = School::find($id);

        return  $school ? $school->update($data) : false;
    }
    public function sys_update(array $data){
        $id=Auth::user()->School_id;
        $now = date('Y-m-d H:i:s');
        if($data['sign_mode']=="mode_1"){
            $data['sign_mode']=1;
        }elseif($data['sign_mode']=="mode_2"){
            $data['sign_mode']=2;
        }
        $data['updated_at']=$now;
        $school = School::find($id);
        return  $school ? $school->update($data) : false;
    }


    public function test($id,$data){
        return School::where('id','=',$id)->update(array('School_Name' => $data));
    }



}
