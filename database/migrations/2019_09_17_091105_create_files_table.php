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
				$table->unsignedInteger( 'product_id' );
				$table->uuid('name');
				$table->char( 'extension', 10 );
				$table->softDeletes();
				$table->timestamps();
				
				$table->foreign( 'product_id' )
					->references( 'id' )
					->on( 'products' )
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
