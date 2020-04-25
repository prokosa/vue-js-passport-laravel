<?php

namespace App\Observers;


use App\Models\User;

class UserObserver
{
	/**
	 * Handle the user "creating" event.
	 *
	 * @param  User $model
	 *
	 * @return void
	 */
	public function creating( User $model )
	{
		if ( !$model->password )
		{
			$random          = str_shuffle( 'abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&' );
			$password        = substr( $random, 0, 10 );
			$model->password = $password;
		}
	}
}