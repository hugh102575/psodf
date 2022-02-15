<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->bigIncrements('id');
            $table->unsignedBigInteger('School_id');
            $table->unsignedBigInteger('order_id');
            $table->string('plan');
            $table->date('started_date');
            $table->date('ended_date');
            $table->date('payed_date')->nullable(); 
            $table->enum('payed', ['1', '0'])->default('0');
            $table->unsignedInteger('price')->nullable();
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
        Schema::dropIfExists('subscribe');
    }
}
