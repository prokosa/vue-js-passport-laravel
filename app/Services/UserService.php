<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.02.20 19:56
 *  ****************************************************************************
 */

namespace App\Services;

use App\Jobs\SendAuthDataJob;
use App\Models\User;

class UserService
{
	/**
	 * @param array $data
	 *
	 * @return User
	 */
	public function store( array $data):User
	{
		$model = new User;
		$model->fill( $data );
		$model->save();
		
		/*	$job = ( new SendAuthDataJob( $model, $password ) )->onQueue( 'user-registration.fifo' )
				->onConnection( 'sqsfifo' );
			dispatch( $job );*/
		
		return $model;
	}
	
	/**
	 * @param array $data
	 * @param User  $user
	 *
	 * @return User
	 */
	public function update( array $data, User $user ):User
	{
		$model = User::lockForUpdate()
			->find( $user->id );
		$model->fill( $data);
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param User $user
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function destroy( User $user ):bool
	{
		return $user->delete();
	}
}