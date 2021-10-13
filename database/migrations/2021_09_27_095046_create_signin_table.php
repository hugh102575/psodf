<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSigninTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signin', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('School_id');
            $table->unsignedBigInteger('Classs_id');
            $table->unsignedBigInteger('Student_id');
            $table->string('Classs_Name');
            $table->string('Student_Name');
            $table->longtext('signin_img');
            $table->date('created_date');
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
        Schema::dropIfExists('signin');
    }
}
