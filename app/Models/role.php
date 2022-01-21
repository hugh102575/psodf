<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    //

    protected $table = 'role';
    public $timestamps = false;

    /** 定義primary key */
    protected $primaryKey = 'RoleID';

    /** primary key是否遞增 */
    public $incrementing = true;

    /** 因key是AI所以不用擺進去 */
    protected $fillable = [
        'School_id',
        'Role_Name',
        'Role_Desc',
        'authority',
        'create_from',
        'update_from',
        'created_at',
        'updated_at'
    ];

}
