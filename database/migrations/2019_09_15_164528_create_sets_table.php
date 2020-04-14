<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 20:11
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('parent_id')->nullable();
	        $table->unsignedInteger('creator_id')->nullable();
	        $table->string('name');
	        $table->unsignedInteger('order')->default(0);
	        $table->string('short')->nullable();
	        $table->softDeletes();
	        $table->timestamps();
	
	        $table->foreign( 'parent_id' )
		        ->references( 'id' )
		        ->on( 'sets' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->foreign( 'creator_id' )
		        ->references( 'id' )
		        ->on( 'users' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sets');
    }
}
