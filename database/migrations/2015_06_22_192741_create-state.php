<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();            
			$table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->nullable()->onDelete('cascade');
            
            $table->string('slug')->unique();
            $table->char('code',10)->index();
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
        Schema::drop('states');
    }
}
