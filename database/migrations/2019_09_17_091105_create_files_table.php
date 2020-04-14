<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 23.09.19 12:01
 *  ****************************************************************************
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'files', function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->char( 'hash_sha256', 64 );
				$table->unsignedInteger( 'creator_id' );
				$table->string( 'name');
				$table->uuid('key');
				$table->char( 'extension', 10 );
				$table->string( 'mime_type' );
				$table->unique( 'hash_sha256' );
				$table->softDeletes();
				$table->timestamps();
				
				$table->foreign( 'creator_id' )
					->references( 'id' )
					->on( 'users' )
					->onUpdate( 'cascade' )
					->onDelete( 'cascade' );
				
				$table->engine = 'InnoDB';
			} );
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists( 'files' );
	}
}
