<?php

namespace App\Observers;

use App\Models\Family;
use Illuminate\Support\Str;

class FamilyObserver
{
	/**
	 * Handle the building type "saving" event.
	 *
	 * @param  Family $model
	 *
	 * @return void
	 */
	public function saving( Family $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * Handle the building "deleting" event.
	 *
	 * @param  Family $model
	 *
	 * @return void
	 */
	public function deleting( Family $model )
	{
		$model->descendants()
			->delete();
		$model->packages()
			->delete();
		$model->sets()
			->detach();
	}
}
