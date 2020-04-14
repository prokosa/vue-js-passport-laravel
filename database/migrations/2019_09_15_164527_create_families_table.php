<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 30.09.19 19:48
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('creator_id')->nullable();
	        $table->uuid('key');
	        $table->string('name');
	        $table->boolean( 'system')->default( false);
	        $table->enum('status',['действующий','недействующий'])->default('действующий');
	        $table->nestedSet();
	        $table->softDeletes();
            $table->timestamps();
            
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
        Schema::dropIfExists('families');
    }
}
