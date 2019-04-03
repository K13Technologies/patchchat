<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacilityIndustry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function ($table) {
            $table->integer('industry_id')->nullable()->unsigned();            
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
        Schema::table('facilities', function ($table) {
            $table->string('industry_id')->drop();
        });
    }
}
