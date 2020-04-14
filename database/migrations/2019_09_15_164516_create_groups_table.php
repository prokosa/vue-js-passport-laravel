<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 29.09.19 21:29
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('creator_id')->nullable();
	        $table->boolean('status')->default( true);
	        $table->softDeletes();
	        $table->timestamps();
	
	        $table->foreign( 'parent_id' )
		        ->references( 'id' )
		        ->on( 'groups' )
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
        Schema::dropIfExists('groups');
    }
}
