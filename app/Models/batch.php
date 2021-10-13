<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class batch extends Model
{
    //

    protected $table = 'batch';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'Batch_Name',
        'Batch_memo',
        'create_from',
        'update_from',
        'created_at',
        'updated_at'
    ];
    public function classs(){
        return $this->hasMany('App\Models\classs','Batch_id','id');
    }
}
