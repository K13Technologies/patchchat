<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Industries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industries', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('facilities_names')->nullable();
            $table->timestamps();
        });
        
        DB::table('industries')->insert(
            array(
                'name' => 'Mining',
                'slug' => 'mining',
                'facilities_names' => 'mine facilities' 
            )
        );
        
        DB::table('industries')->insert(
            array(
                'name' => 'Energy',
                'slug' => 'energy',
                'facilities_names' => 'oil and gas facilities'
            )
        );
        
        DB::table('industries')->insert(
            array(
                'name' => 'Forestry',
                'slug' => 'forestry',
                'facilities_names' => 'logging camps and sawmill facilities'
            )
        );
        
        DB::table('industries')->insert(
            array(
                'name' => 'Hydro',
                'slug' => 'hydro',
                'facilities_names' => 'hydroelectric powerstation facilities'
            )
        );
        
        DB::table('industries')->insert(
            array(
                'name' => 'Solar',
                'slug' => 'solar',
                'facilities_names' => 'solar farm and solar power station facilities'
            )
        );
        
        DB::table('industries')->insert(
            array(
                'name' => 'Wind',
                'slug' => 'wind',
                'facilities_names' => 'onshore and offshore wind farm facilities'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('industries');
    }
}
