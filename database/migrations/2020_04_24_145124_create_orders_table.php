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

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('payment_system_id');
	        $table->unsignedInteger('client_id');
	        $table->enum( 'status',['paid','unpaid','pending']);
	        $table->string( 'comment')->nullable();
	        $table->softDeletes();
	        $table->timestamps();
	
	        $table->foreign( 'product_id' )
		        ->references( 'id' )
		        ->on( 'products' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	        
	        $table->foreign( 'client_id' )
		        ->references( 'id' )
		        ->on( 'clients' )
		        ->onUpdate( 'cascade' )
		        ->onDelete( 'cascade' );
	        
	        $table->foreign( 'payment_system_id' )
		        ->references( 'id' )
		        ->on( 'payment_systems' )
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
        Schema::dropIfExists('orders');
    }
}
