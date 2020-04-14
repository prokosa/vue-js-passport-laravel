<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 20:21
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            $table->unique(['user_id','group_id']);
            $table->timestamps();
	
	        $table->foreign( 'user_id' )
		        ->references( 'id' )
		        ->on( 'users' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->foreign( 'group_id' )
		        ->references( 'id' )
		        ->on( 'groups' )
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
        Schema::dropIfExists('user_group');
    }
}
