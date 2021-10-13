<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('School_id');
            //$table->unsignedBigInteger('Batch_id');
            $table->unsignedBigInteger('Classs_id');
            $table->unsignedBigInteger('order');
            $table->string('STU_id');
            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('school')->nullable();
            $table->string('grade')->nullable();
            $table->string('profile')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_line')->nullable();
            $table->string('memo')->nullable();

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
        Schema::dropIfExists('student');
    }
}
