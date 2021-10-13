<?php

namespace App\Repositories;

use App\Models\linekey;
use Auth;

class LineKeyRepository
{

    public function store($data){
        return  linekey::create($data);
    }
    public function check($School_id,$user_id){
        return  linekey::where('School_id',$School_id)->where('user_id',$user_id)->first();
    }



}
