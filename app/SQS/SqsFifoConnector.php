<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 04.03.20 22:25
 *  ****************************************************************************
 */

namespace App\SQS;

use Aws\Sqs\SqsClient;
use Illuminate\Support\Arr;

class SqsFifoConnector extends \Illuminate\Queue\Connectors\SqsConnector
{
	public function connect( array $config )
	{
		$config = $this->getDefaultConfiguration( $config );
		
		if ( $config['key'] && $config['secret'] )
		{
			$config['credentials'] = Arr::only( $config, [ 'key', 'secret' ] );
		}
		
		return new SqsFifoQueue(
			new SqsClient( $config ), $config['queue'], Arr::get( $config, 'prefix', '' )
		);
	}
}