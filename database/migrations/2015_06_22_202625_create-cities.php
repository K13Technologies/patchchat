<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();            
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->nullable()->onDelete('cascade');

            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->nullable()->onDelete('cascade');

            $table->string('slug')->unique();
            $table->string('name');
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
        Schema::drop('cities');
    }
    
}
