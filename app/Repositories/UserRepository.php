<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\role;
use Illuminate\Support\Facades\Hash;
use Auth;


class UserRepository
{
    public function find($id){
        return User::find($id);
    }
    public function owner($id){
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
    
    public function create(array $data){
        $now = date('Y-m-d H:i:s');
        $data['School_id'] = Auth::user()->school->id;
        $data['password'] = Hash::make($data['password']);
        $data['create_from'] = Auth::user()->id;
        $data['created_at'] = $now;
        $data['update_from'] = Auth::user()->id;
        $data['updated_at'] = $now;
        return User::create($data);
    }
    public function update(array $data){
        $id=Auth::user()->id;
        $user = User::find($id);
        if($data['button']=="m1"){
            $data['name']=$data['profileName'];
            $result=  $user ? $user->update($data) : false;
        }else if($data['button']=="m2"){
            $data['password']=Hash::make($data['profilePW_new']);
            $result=  $user ? $user->update($data) : false;
        }
        return $result;
    }
    public function update_account($id,array $data){
        $user = User::find($id);
        return  $user ? $user->update($data) : false;
    }
    public function delete($id){
        return User::destroy($id);
    }
    public function change_active($id, $new_status){
        $user=User::find($id);
        $result =array();
        $result[0] = $user ? $user->update(array('active'=>$new_status)) : false;
        $result[1]=$new_status;
        return $result;
    }

    public function check_only_admin($id, $RoleID){
        $pf_users=User::where('School_id','=',Auth::user()->school->id)->get();

        $admin_count=0;
        $admin=array();
        foreach($pf_users as $user){
            $role = $user->role;
            if($role->Role_Name == '安親班管理員'){
                array_push($admin,$role->RoleID);
                $admin_count++;
            }
        }

        if($admin_count<=1){
            if($admin_count==0){
                return 'no_admin';
            }
            $this_user=$this->find($id);
            $this_role=$this_user->RoleID;
            if(in_array($this_role,$admin)){
                $role_req = role::find($RoleID);
                if($role_req->Role_Name != '安親班管理員'){
                    return 'admin_only_me_failed';
                }else{
                    return 'admin_only_me_ok';
                }
            }else{
                return 'admin_only_you';
            }
        }else{
            return 'fine';
        }
    }


}
