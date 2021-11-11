<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignMsgToSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            //$table->text('in_msg')->after('sign_mode')->default('您的孩子@Name已經到班囉!')->nullable();
            //$table->text('out_msg')->after('in_msg')->default('您的孩子@Name已經下課囉!')->nullable();
            $table->text('in_msg')->after('sign_mode')->nullable();
            $table->text('out_msg')->after('in_msg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school', function (Blueprint $table) {
            //
        });
    }
}
