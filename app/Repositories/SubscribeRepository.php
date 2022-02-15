<?php

namespace App\Repositories;

use App\Models\subscribe;

class SubscribeRepository
{
    public function list_all(){
        return subscribe::all();
    }

    public function find($id){
        return subscribe::find($id);
    }
  
    public function store(array $data){
        $now = date('Y-m-d H:i:s');
        $order_id=$this->new_order_id();
        $data['School_id']=$data['school_id'];
        $data['order_id']=$order_id;
        $data['created_at']=$now;

        $result=subscribe::create($data);
        $return=array();
        $return[0]=$result;
        $return[1]=$order_id;
        
        return $return;
    }

    public function delete($id){
        return subscribe::destroy($id);
    }

    public function update($id, array $data){
        $subscribe = subscribe::find($id);
        $result=$subscribe ? $subscribe->update($data) : false;
        $return=array();
        $return[0]=$result;
        $return[1]=$subscribe->order_id;
        return $return;
    }
    public function new_order_id(){
        $now = date('Ymd');
        $test_num="";
        for($i=0; $i<8; $i++){
            $test_num=$test_num.strval(rand(0,9));
        }
        $test_order_id=strval($now).strval($test_num);
        while(subscribe::where('order_id',$test_order_id)->exists()) {
            $test_num="";
            for($i=0; $i<8; $i++){
                $test_num=$test_num.strval(rand(0,9));
            }
            $test_order_id=strval($now).strval($test_num);
        }
        return $test_order_id;
    }
    public function query_due($query_date,$query_weeks){
        $from_date = strtotime($query_date);
        $due_date_= strtotime("+".strval($query_weeks)." week", $from_date);
        $due_date=date('Y-m-d', $due_date_);
        $return=array();
        $return[0]=subscribe::whereBetween('ended_date', [$from_date, $due_date])->get();
        $return[1]=strval(date('Y-m-d', $from_date));
        $return[2]=strval($due_date);
        //return subscribe::whereBetween('ended_date', [$from_date, $due_date])->get();   
        return $return;
    }
}
