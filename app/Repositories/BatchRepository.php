<?php

namespace App\Repositories;

use App\Models\batch;
use Auth;

class BatchRepository
{
    public function find($id){
        return batch::find($id);
    }
    public function store(array $data){
        $now = date('Y-m-d H:i:s');
        $data['School_id']=Auth::user()->School_id;
        $data['create_from']=Auth::user()->account;
        $data['created_at']=$now;
        return  batch::create($data);
    }
    public function update(array $data,$id){
        $now = date('Y-m-d H:i:s');
        $data['updated_at']=$now;
        $batch = batch::find($id);
        return  $batch ? $batch->update($data) : false;
    }
    public function delete($id){
        return batch::destroy($id);
    }


}
