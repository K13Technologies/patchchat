<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacilityRevies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_categories', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();            
            $table->string("name");
            $table->smallInteger("ordernr");            
        });
        
        Schema::create('reviews', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            
            $table->integer('facility_id')->unsigned();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->float("rating")->nullable();
            
            $table->text("comment")->nullable();
            
            $table->integer('status')->default(0);
            $table->integer('upvotes')->unsigned()->default(0);
            $table->integer('downvotes')->unsigned()->default(0);
            
            $table->timestamps();
        });
        
        Schema::create('review_items', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
        
            $table->integer('facility_id')->unsigned();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->integer('review_category_id')->unsigned();
            $table->foreign('review_category_id')->references('id')->on('review_categories')->onDelete('cascade');
            
            $table->smallInteger("rating")->unsigned();        
            $table->integer('status')->default(0);
        
            $table->timestamps();
        });
        
        $i=1;
        DB::table('review_categories')->insert(
            array(
                'name' => 'Food',
                'ordernr' => $i
            )
        );
        DB::table('review_categories')->insert(
            array(
                'name' => 'Rooms',
                'ordernr' => $i
            )
        );
        DB::table('review_categories')->insert(
            array(
                'name' => 'Sleep Quality',
                'ordernr' => $i
            )
        );
        DB::table('review_categories')->insert(
            array(
                'name' => 'Service',
                'ordernr' => $i
            )
        );

        DB::table('review_categories')->insert(
            array(
                'name' => 'Value',
                'ordernr' => $i
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
        Schema::drop('review_categories');
        Schema::drop('reviews');
        Schema::drop('review_items');
        
    }
}
