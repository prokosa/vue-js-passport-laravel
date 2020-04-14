<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.09.19 11:52
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfaVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfa_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('creator_id');
	        $table->unsignedInteger('file_id');
            $table->unsignedInteger('version');
	        $table->uuid('key');
	        $table->char( 'hash_sha256', 64 );
	        $table->softDeletes();
	        $table->timestamps();
	
	        $table->foreign( 'package_id' )
		        ->references( 'id' )
		        ->on( 'packages' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	
	        $table->foreign( 'creator_id' )
		        ->references( 'id' )
		        ->on( 'users' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	        
	        $table->foreign( 'file_id' )
		        ->references( 'id' )
		        ->on( 'files' )
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
        Schema::dropIfExists('rfa_versions');
    }
}
