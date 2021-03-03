<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customerwallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerwallet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customername');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('phone no');
            $table->float('balance');
            $table->integer('user_id');
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
        Schema::dropIfExists('customerwallet');
    }
}
