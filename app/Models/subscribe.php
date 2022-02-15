<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    //

    protected $table = 'subscribe';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'order_id',
        'plan',
        'started_date',
        'ended_date',
        'payed_date',
        'payed',
        'price',
        'created_at',
        'updated_at'
    ];

    public function school(){
        return $this->hasOne('App\Models\School','id','School_id');
    }
}
