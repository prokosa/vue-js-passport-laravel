<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 30.09.19 19:54
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('family_id');
	        $table->unsignedInteger('creator_id')->nullable();
	        $table->unsignedInteger('parent_id')->nullable();
	      //  $table->text('properties')->nullable();
            //$table->unsignedInteger('edition')->default(0);
	        $table->string( 'name');
	       // $table->unsignedSmallInteger('version')->default(0);
            $table->uuid('key');
            $table->enum('status',['действующий','недействующий'])->default('действующий');
	        $table->softDeletes();
	        $table->timestamps();
	
	        $table->foreign( 'family_id' )
		        ->references( 'id' )
		        ->on( 'families' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	        
	        $table->foreign( 'creator_id' )
		        ->references( 'id' )
		        ->on( 'users' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->foreign( 'parent_id' )
		        ->references( 'id' )
		        ->on( 'packages' )
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
        Schema::dropIfExists('packages');
    }
}
