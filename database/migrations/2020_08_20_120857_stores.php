<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Stores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('store_name');
            $table->string('store_website');
            $table->string('store_logo');
            $table->string('store_description');
            $table->string('store_address');
            $table->string('store_contact_no');
            $table->string('store_status');
            $table->string('store_closed_message');
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
