<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->bigIncrements('RoleID'); // 角色代碼
            $table->unsignedBigInteger('School_id');  // 平台編號
            $table->string('Role_Name'); // 角色名稱
            $table->string('Role_Desc')->nullable(); // 角色說明
            $table->text('authority');
            $table->string('create_from');
            $table->string('update_from')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
