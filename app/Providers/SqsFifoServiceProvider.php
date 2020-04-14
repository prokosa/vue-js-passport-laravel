<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 04.03.20 22:27
 *  ****************************************************************************
 */

namespace App\Providers;


use App\SQS\SqsFifoConnector;

class SqsFifoServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function register()
	{
		$this->app->afterResolving( 'queue',
			function ( $manager ) {
				$manager->addConnector( 'sqsfifo',
					function () {
						return new SqsFifoConnector();
					} );
			} );
	}
}