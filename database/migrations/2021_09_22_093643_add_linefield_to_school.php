<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinefieldToSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school', function (Blueprint $table) {
            $table->string('LineID',100)->after('School_Name')->nullable(); // Line@ ID
            $table->string('LineChannelSecret',100)->after('LineID')->nullable();
            $table->string('LineChannelAccessToken',500)->after('LineChannelSecret')->nullable();
            $table->string('LineChannelName',100)->after('LineChannelAccessToken')->nullable();
            $table->string('LineQR')->after('LineChannelName')->nullable();
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
