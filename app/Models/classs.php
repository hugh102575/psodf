<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class classs extends Model
{
    //

    protected $table = 'classs';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'Batch_id',
        'Classs_Name',
        'Classs_memo',
        //'Student_List',
        'create_from',
        'update_from',
        'created_at',
        'updated_at'
    ];

    public function student(){
        return $this->hasMany('App\Models\student','Classs_id','id');
    }
    public function batch(){
        return $this->hasOne('App\Models\batch','id','Batch_id');
    }
}
