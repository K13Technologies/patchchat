<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacilityPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('facility_id')->unsigned();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            
            $table->integer("type")->unsigned()->default(1);
            $table->string("filename");
            $table->string("path");
            
            $table->string("caption")->nullable();
            $table->string("description")->nullable();
            $table->integer("ordernr")->unsigned();
            
            $table->integer("width")->nullable();
            $table->integer("height")->nullable();
            
            $table->integer('status')->default(0);
            
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
        Schema::drop('photos');
    }
}
