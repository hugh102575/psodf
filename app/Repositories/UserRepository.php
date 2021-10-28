<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{   public function owner($id){
        return User::where('School_id',$id)->first();
    }
    public function api_token_owner($api_token){
        return User::where('api_token',$api_token)->first();
    }
    public function app_login(array $data){
        $result=false;
        $user = User::where('email',$data['email'])->first();
        if($user){
            if (Hash::check($data['password'], $user->password)){
                $result=$user;
            }
        }
        return $result;

    }


}
