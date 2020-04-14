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


use App\Http\Requests\UserRequest;
use App\Jobs\SendAuthDataJob;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserService
{
	/**
	 * @param FormRequest $request
	 *
	 * @return User
	 */
	public function store( FormRequest $request )
	{
		$model     = new User;
		$model->fill( $request->all() );
		$model->save();
		
	/*	$job = ( new SendAuthDataJob( $model, $password ) )->onQueue( 'user-registration.fifo' )
			->onConnection( 'sqsfifo' );
		dispatch( $job );*/
		
		return $model;
	}
	
	/**
	 * @param User        $user
	 * @param UserRequest $request
	 *
	 * @return mixed
	 */
	public function update( User $user, UserRequest $request )
	{
		$model = User::lockForUpdate()
			->find( $user->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param User $user
	 *
	 * @throws \Exception
	 */
	public function destroy( User $user )
	{
		$user->delete();
	}
}