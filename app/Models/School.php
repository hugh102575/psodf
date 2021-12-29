<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class school extends Model
{
    //

    protected $table = 'school';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_Name',
        //'secret_key',
        'create_from',
        'update_from',
        'created_at',
        'updated_at',

        'LineID',
        'LineChannelSecret',
        'LineChannelAccessToken',
        'LineChannelName',
        'thresh',
        'phone',
        'address',
        'device_id',
        'sign_mode',
        'in_msg',
        'out_msg'
    ];

    public function User(){
        return $this->hasOne('App\Models\User','School_id','id');
    }
    public function classs(){
        return $this->hasMany('App\Models\classs','School_id','id');
    }
    public function batch(){
        return $this->hasMany('App\Models\batch','School_id','id');
    }
    public function student(){
        return $this->hasMany('App\Models\student','School_id','id');
    }
    public function signin(){
        return $this->hasMany('App\Models\signin','School_id','id');
    }

}
