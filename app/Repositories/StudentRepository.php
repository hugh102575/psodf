<?php

namespace App\Repositories;

use App\Models\student;
use Auth;

class StudentRepository
{
    public function find($id){
        return student::find($id);
    }
    public function find_stid($stid){
        return student::where('STU_id',$stid)->where('School_id',Auth::user()->School_id)->first();
    }
    public function search_name($name){
        return student::where('name',$name)->where('School_id',Auth::user()->School_id)->get();
    }
    public function store(array $data,$classs,$classs_id,$count){
        $now = date('Y-m-d H:i:s');
        $data['School_id']=Auth::user()->School_id;
        $STU_id =strval(Auth::user()->School_id)
                .strval($classs->batch->id)
                .strval($classs_id)
                .strval($random_num=strval(rand(1000,9999)));
        while(student::where('STU_id',$STU_id)->exists()) {
            $STU_id =strval(Auth::user()->School_id)
                .strval($classs->batch->id)
                .strval($classs_id)
                .strval($random_num=strval(rand(1000,9999)));
        }
        $data['STU_id']=$STU_id;
        //$data['Batch_id']=$batch_id;
        $data['Classs_id']=$classs_id;
        $data['order']=$count;
        $data['create_from']=Auth::user()->account;
        $data['created_at']=$now;
        return  student::create($data);
    }
    public function update(array $data,$classs_id,$count,$id){
        $now = date('Y-m-d H:i:s');
        $data['updated_at']=$now;
        $data['School_id']=Auth::user()->School_id;
        //$data['Batch_id']=$batch_id;
        $data['Classs_id']=$classs_id;
        $data['order']=$count;
        $student = student::find($id);
        return  $student ? $student->update($data) : false;
    }
    public function profile($id, $image_path){
        return student::where('id','=',$id)->update(array('profile' => $image_path));
    }
    public function single_update(array $data,$id){
        $now = date('Y-m-d H:i:s');
        $data['updated_at']=$now;
        $student = student::find($id);
        return  $student ? $student->update($data) : false;
    }
    public function get_student($id){
        return student::where('School_id',Auth::user()->School_id)->where('Classs_id',$id)->get();
    }
    public function get_all_student(){
        return student::where('School_id',Auth::user()->School_id)->get();
    }
    public function search_student($student_name){

        $student_all = student::where('School_id',Auth::user()->School_id)->get();
        $result=array();
        $result['student']=array();
        $result['classs']=array();
        foreach($student_all as $student){
            if($student['name']==$student_name){
                array_push($result['student'],$student->name);
                array_push($result['classs'],$student->classs->Classs_Name);
            }

        }


        return json_encode($result);
    }
    public function delete($id){
        return student::destroy($id);
    }

    public function check_stuid($STU_id,$school_id){
        return student::where('School_id',$school_id)->where('STU_id',$STU_id)->first();
    }
    public function check_stuName($STU_name,$school_id){
        return student::where('School_id',$school_id)->where('name',$STU_name)->get();
    }
    public function add_parent_line($id,$userId){
        return student::where('id','=',$id)->update(array('parent_line' => $userId));
    }
    public function add_parent_line3($student,$userId_official,$userId_notify){
        $id=$student->id;
        $multi_line=$student->parent_line_multi;
        $multi_line_notify=$student->parent_line_multi_notify;
        $line_array=array();
        $line_array2=array();
        if(isset($multi_line) && isset($multi_line_notify)){
            $multi_line_d=json_decode($multi_line,true);
            foreach($multi_line_d as $pline){
                array_push($line_array,$pline);
            }
            array_push($line_array,$userId_official);
            $multi_line_d2=json_decode($multi_line_notify,true);
            foreach($multi_line_d2 as $pline){
                array_push($line_array2,$pline);
            }
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array),'parent_line_multi_notify'=>json_encode($line_array2)));
        }elseif(isset($multi_line) && $multi_line_notify==null){
            $multi_line_d=json_decode($multi_line,true);
            foreach($multi_line_d as $pline){
                array_push($line_array,$pline);
            }
            array_push($line_array,$userId_official);
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array),'parent_line_multi_notify'=>json_encode($line_array2)));
        }elseif($multi_line==null && isset($multi_line_notify)){
            array_push($line_array,$userId_official);
            $multi_line_d2=json_decode($multi_line_notify,true);
            foreach($multi_line_d2 as $pline){
                array_push($line_array2,$pline);
            }
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array),'parent_line_multi_notify'=>json_encode($line_array2)));
        }else{
            array_push($line_array,$userId_official);
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array),'parent_line_multi_notify'=>json_encode($line_array2)));

        }

        /*if(isset($multi_line_notify)){
            $multi_line_d2=json_decode($multi_line_notify,true);
            foreach($multi_line_d2 as $pline){
                array_push($line_array2,$pline);
            }
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi_notify' => json_encode($line_array2)));
        }else{
            array_push($line_array2,$userId_notify);
            return student::where('id','=',$id)->update(array('parent_line_multi_notify' => json_encode($line_array2)));
        }*/

    }
    public function add_parent_line2($student,$userId,$mode){
        $id=$student->id;
        if($mode=="official"){
            $multi_line=$student->parent_line_multi;
            $line_array=array();
            if(isset($multi_line)){
                $multi_line_d=json_decode($multi_line,true);

                if (in_array($userId, $multi_line_d)){
                    return false;
                }else{
                    foreach($multi_line_d as $pline){
                        array_push($line_array,$pline);
                    }
                    array_push($line_array,$userId);
                    return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array)));
                }

            }else{
                array_push($line_array,$userId);
                return student::where('id','=',$id)->update(array('parent_line_multi' => json_encode($line_array)));
            }
        }else if($mode=="notify"){
            $multi_line=$student->parent_line_multi_notify;
            $line_array=array();
            if(isset($multi_line)){
                $multi_line_d=json_decode($multi_line,true);

                if (in_array($userId, $multi_line_d)){
                    return false;
                }else{
                    foreach($multi_line_d as $pline){
                        array_push($line_array,$pline);
                    }
                    array_push($line_array,$userId);
                    return student::where('id','=',$id)->update(array('parent_line_multi_notify' => json_encode($line_array)));
                }

            }else{
                array_push($line_array,$userId);
                return student::where('id','=',$id)->update(array('parent_line_multi_notify' => json_encode($line_array)));
            }
        }

    }
    public function parent_supervise($school_id,$LineID){
        $my_child=array();
        $school_st= student::where('School_id',$school_id)->get();
        if(count($school_st)!=0){
            foreach($school_st as $s){
                if($s->parent_line_multi!=null){
                    $parent_line_multi_a=json_decode($s->parent_line_multi,true);
                    foreach($parent_line_multi_a as $p){
                        if($p==$LineID){
                            array_push($my_child,$s);
                        }
                    }
                }
            }
        }
        return $my_child;
    }



}
