<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacilityPrimaryPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('facilities', function ($table) {
            $table->integer('featured_photo')->nullable()->unsigned();            
            $table->foreign('featured_photo')->references('id')->on('photos')->onDelete('set null');            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facilities', function ($table) {
            $table->string('image')->drop();
        });
        
    }
}
