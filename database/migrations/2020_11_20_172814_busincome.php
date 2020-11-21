<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Busincome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('busincome', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bus_id');
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->unsignedBigInteger('busdriverlist_id');
            $table->foreign('busdriverlist_id')->references('id')->on('busdriverlist');
            $table->unsignedBigInteger('customerrideinfo_id');
            $table->foreign('customerrideinfo_id')->references('id')->on('customerrideinfo');
            $table->float('balance');
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
        Schema::dropIfExists('busincome');
    }
}
