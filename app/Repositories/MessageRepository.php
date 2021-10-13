<?php

namespace App\Repositories;

use App\Models\message;
use App\Models\student;
use Auth;

class MessageRepository
{
    public function find($id){
        return message::find($id);
    }
    public function get_all_message(){
        return message::where('School_id',Auth::user()->School_id)->get();
    }
    public function get_all_student(){
        return student::where('School_id',Auth::user()->School_id)->get();
    }
    public function store(array $data){
        $now = date('Y-m-d H:i:s');
        $me_data['School_id']=Auth::user()->School_id;
        $me_data['name']=$data['Message_Name'];
        $me_data['data']=$data['Message_Data'];
        $me_data['created_at']=$now;
        return  message::create($me_data);
    }
    public function update(array $data,$id){
        
        $now = date('Y-m-d H:i:s');
        $data['updated_at']=$now;
        $data['name']=$data['Message_Name'];
        $data['data']=$data['Message_Data'];
        $message = message::find($id);
        return  $message ? $message->update($data) : false;
    }
    public function delete($id){
        return message::destroy($id);
    }
    
    

}
