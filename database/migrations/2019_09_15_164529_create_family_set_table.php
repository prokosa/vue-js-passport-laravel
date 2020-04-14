<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 30.09.19 21:26
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilySetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_set', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('family_id')->nullable();
            $table->unsignedInteger('set_id')->nullable();
	        $table->softDeletes();
            $table->timestamps();
	
	        $table->foreign( 'family_id' )
		        ->references( 'id' )
		        ->on( 'families' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->foreign( 'set_id' )
		        ->references( 'id' )
		        ->on( 'sets' )
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
        Schema::dropIfExists('family_set');
    }
}
