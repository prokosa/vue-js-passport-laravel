<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Str;

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
		$model->key = (string) Str::uuid();
	}
}