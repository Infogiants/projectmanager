<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('project_category_id');
            $table->string('project_name');
            $table->tinyInteger('project_type');
            $table->float('project_price');
            $table->text('project_description');
            $table->date('project_start_date')->nullable();
            $table->date('project_end_date')->nullable();
            $table->tinyInteger('project_status');
            $table->unsignedInteger('client_user_id');
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('project_category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
}
