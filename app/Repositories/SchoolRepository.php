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
        $data['phone']=$data['manager_phone'];
        $data['updated_at']=$now;
        $school = School::find($id);
        $user=User::where('School_id',$id)->first();
        $user->update(array('name' => $data['manager_name']));
        return  $school ? $school->update($data) : false;
    }


    public function test($id,$data){
        return School::where('id','=',$id)->update(array('School_Name' => $data));
    }



}
