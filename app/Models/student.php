<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    //

    protected $table = 'student';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        //'Batch_id',
        'Classs_id',
        'order',
        'STU_id',
        'name',
        'gender',
        'school',
        'grade',
        'profile',
        'parent_name',
        'parent_phone',
        'parent_line',
        'memo',
        'create_from',
        'update_from',
        'created_at',
        'updated_at',
        'parent_line_multi'
    ];

    public function classs(){
        return $this->hasOne('App\Models\classs','id','Classs_id');
    }
}
