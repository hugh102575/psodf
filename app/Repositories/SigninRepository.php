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


}
