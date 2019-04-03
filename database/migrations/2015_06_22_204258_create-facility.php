<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('facilities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->nullable()->onDelete('cascade');
        
            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states')->nullable()->onDelete('cascade');
        
            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->nullable()->onDelete('cascade');

            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->nullable()->onDelete('cascade');
            
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullable()->onDelete('cascade');
            
            $table->string('slug')->unique();
            
            $table->string('name');
            $table->string('company')->nullable();
            
            $table->string('lsd')->nullable();
            $table->decimal('latitude',11,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();
            $table->string('address')->nullable();
            $table->string('phone_reservations')->nullable();
            $table->string('phone_main')->nullable();
            $table->string('phone_cell')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            
            $table->text('directions')->nullable();
            $table->string('city')->nullable();
            $table->text('description')->nullable();
            $table->integer('beds')->nullable();
            
            $table->integer('status')->default(0);
            $table->float('rating')->nullable();
            
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
        Schema::drop('facilities');
    }
}
