<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Remainingamount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remainingamount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customerrideinfo_id');
           // $table->foreign('customerrideinfo_id')->references('id')->on('customerrideinfo');
            $table->unsignedBigInteger('customer_id');
           // $table->foreign('customer_id')->references('id')->on('customerwallet');
            $table->float('remainingbalance');
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
        Schema::dropIfExists('remainingamount');
    }
}
