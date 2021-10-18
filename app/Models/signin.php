<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class signin extends Model
{
    //

    protected $table = 'signin';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'Classs_id',
        'Student_id',
        'Classs_Name',
        'Student_Name',
        'sign',
        'signin_img',
        'created_date',
        'created_at',
        'updated_at'
    ];

}
