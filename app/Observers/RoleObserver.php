<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
	/**
	 * Handle the group "creating" event.
	 *
	 * @param  Role $model
	 *
	 * @return void
	 */
	public function creating( Role $model )
	{
		$model->creator_id = auth()->user()->id;
	}
	
	/**
	 * Handle the group "deleting" event.
	 *
	 * @param  Role $model
	 *
	 * @return void
	 */
	public function deleting( Role $model )
	{
		$model->departments()
			->delete();
		$model->users()
			->detach();
	}
	
}
