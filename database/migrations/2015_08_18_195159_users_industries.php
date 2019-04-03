<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersIndustries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_industries', function ($table) {
            $table->increments('id');
            
            $table->integer('user_id')->unsigned();            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');            
            
            $table->integer('industry_id')->unsigned();            
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_industries');
    }
}
