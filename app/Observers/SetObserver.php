<?php

namespace App\Observers;

use App\Models\Set;

class SetObserver
{
	/**
	 * Handle the set "creating" event.
	 *
	 * @param  Set $model
	 *
	 * @return void
	 */
	public function creating( Set $model )
	{
		$model->creator_id = auth()->user()->id;
	}
	
	/**
	 * @param Set $model
	 */
	public function deleting( Set $model )
	{
		$model->children()
			->delete();
	}
}
