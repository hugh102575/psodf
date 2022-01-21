<?php

namespace App\Repositories;

use App\Models\role;
use Illuminate\Support\Facades\Hash;
use Auth;


class RoleRepository
{   
    public function find($RoleID){
        return role::find($RoleID);
    }
    public function create(array $data){
        $authority_null=true;
        if(isset($data['authority'])){
            $data['authority'] = implode(',', $data['authority']);
            $authority_null=false;
        }
        if($authority_null){
            $data['authority']='empty';
        }
        $now = date('Y-m-d H:i:s');
        $data['School_id'] = Auth::user()->school->id;
        $data['create_from'] = Auth::user()->RoleID;
        $data['created_at'] = $now;
        $data['update_from'] = Auth::user()->RoleID;
        $data['updated_at'] = $now;

        return role::create($data);
    }
    public function update(array $data,$id){
        $authority_null=true;
        if(isset($data['authority'])){
            $data['authority'] = implode(',', $data['authority']);
            $authority_null=false;
        }
        if($authority_null){
            $data['authority']='empty';
        }
        $data['update_from'] = Auth::user()->RoleID;
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $role = role::find($id);
        return $role ? $role->update($data) : false;
    }
    public function delete($id){
        $pf_users=Auth::user()->school->User;
        $role_conflict = false;
        foreach($pf_users as $user){
            if($user->RoleID == $id){
                $role_conflict = true;
                break;
            }else{
                $role_conflict=false;
            }
        }
        if($role_conflict){
            return "role_conflict";
        }else{
            return role::destroy($id);
        }
        //return role::destroy($id);
    }
    public function check_name($name){
        return role::where('School_id',Auth::user()->school->id)->where('Role_Name',$name)->first();
    }
    public function check_name2($name,$id){
        $role = role::where('School_id',Auth::user()->school->id)->where('Role_Name',$name)->first();
        if($role){
            if($role->RoleID==$id){
                $repeat_name=false; 
            }else{
                $repeat_name=true;
            }
        }else{
            $repeat_name=false;
        }
        return $repeat_name;
    }
    
  


}
