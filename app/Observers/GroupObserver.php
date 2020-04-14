<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
	/**
	 * Handle the group "creating" event.
	 *
	 * @param  Group $model
	 *
	 * @return void
	 */
	public function creating( Group $model )
	{
		$model->creator_id = auth()->user()->id;
	}
	
	/**
	 * Handle the group "deleting" event.
	 *
	 * @param  Group $model
	 *
	 * @return void
	 */
	public function deleting( Group $model )
	{
		$model->departments()
			->delete();
		$model->users()
			->detach();
	}
	
}
