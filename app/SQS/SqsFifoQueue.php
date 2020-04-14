<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 04.03.20 22:24
 *  ****************************************************************************
 */

namespace App\SQS;


class SqsFifoQueue extends \Illuminate\Queue\SqsQueue
{
	public function pushRaw( $payload, $queue = null, array $options = [] )
	{
		$response = $this->sqs->sendMessage( [
			'QueueUrl'               => $this->getQueue( $queue ),
			'MessageBody'            => $payload,
			'MessageGroupId'         => uniqid(),
			'MessageDeduplicationId' => uniqid(),
		] );
		
		return $response->get( 'MessageId' );
	}
}