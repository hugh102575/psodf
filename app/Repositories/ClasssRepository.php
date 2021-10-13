<?php

namespace App\Repositories;

use App\Models\classs;
use Auth;

class ClasssRepository
{
    public function find($id){
        return classs::find($id);
    }
    public function store(array $data){
        $now = date('Y-m-d H:i:s');
        $data['School_id']=Auth::user()->School_id;
        $data['create_from']=Auth::user()->email;
        $data['created_at']=$now;
        return  classs::create($data);
    }
    public function update(array $data,$id){
        $now = date('Y-m-d H:i:s');
        $data['updated_at']=$now;
        $classs = classs::find($id);
        return  $classs ? $classs->update($data) : false;
    }
    public function delete($id){
        return classs::destroy($id);
    }
    public function search_student($student_name){

        $classs_all = classs::where('School_id',Auth::user()->School_id)->get();
        $result=array();
        $result['student']=array();
        $result['classs']=array();
        foreach($classs_all as $classs){
            if($classs->Student_List!=null){
                $Student_List=json_decode($classs->Student_List,true);
                foreach($Student_List as $student){
                    if($student['name']==$student_name){
                        array_push($result['student'],$student);
                        array_push($result['classs'],$classs->Classs_Name);
                    }
                }
            }

        }
        return json_encode($result);
    }
    public function batch($id){
        return classs::where('Batch_id',$id)->get();
    }

}
