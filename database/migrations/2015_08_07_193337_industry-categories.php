<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndustryCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('industries_categories', function ($table) {
            $table->increments('id');
            
            $table->integer('category_id')->unsigned();            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');            
            
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
        Schema::drop('industries_categories');
    }
}
