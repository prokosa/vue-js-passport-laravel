<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{
	/**
	 * Handle the package version "creating" event.
	 *
	 * @param  Order $model
	 *
	 * @return void
	 */
	public function creating( Order $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * @param Order $model
	 *
	 * @throws \Exception
	 */
	public function deleting( Order $model )
	{
		$model->library()
			->delete();
		$model->properties()
			->delete();
		$model->image()
			->delete();
		$model->size_table()
			->delete();
		$model->search_table()
			->delete();
		$model->description()
			->delete();
	}
	
	/**
	 * Handle the package version "restored" event.
	 *
	 * @param  Order $model
	 *
	 * @return void
	 */
	public function restored( Order $model )
	{
		//
	}
	
	/**
	 * Handle the package version "force deleted" event.
	 *
	 * @param  Order $model
	 *
	 * @return void
	 */
	public function forceDeleted( Order $model )
	{
		//
	}
}
