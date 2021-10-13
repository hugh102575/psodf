<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class linekey extends Model
{
    //

    protected $table = 'linekey';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'id';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'key',
        'user_id',
        'created_at',
        'updated_at'
    ];

}
