<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
	/**
	 * Handle the building type "saving" event.
	 *
	 * @param  Category $model
	 *
	 * @return void
	 */
	public function saving( Category $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * Handle the building "deleting" event.
	 *
	 * @param  Category $model
	 *
	 * @return void
	 */
	public function deleting( Category $model )
	{
		$model->descendants()
			->delete();
		$model->packages()
			->delete();
		$model->sets()
			->detach();
	}
}
