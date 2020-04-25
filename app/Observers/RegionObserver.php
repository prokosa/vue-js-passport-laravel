<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class RegionObserver
{
	/**
	 * Handle the package "creating" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function creating( Product $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * Handle the package "saved" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function saved( Product $model )
	{
		//
	}
	
	/**
	 * Handle the package "deleting" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function deleting( Product $model )
	{
		$model->children()
			->delete();
		
		$model->versions()
			->delete();
		
		$model->rfa_versions()
			->delete();
	}
	
	/**
	 * Handle the package "deleted" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function deleted( Product $model )
	{
		//
	}
	
	/**
	 * Handle the package "restored" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function restored( Product $model )
	{
		//
	}
	
	/**
	 * Handle the package "force deleted" event.
	 *
	 * @param  Product $model
	 *
	 * @return void
	 */
	public function forceDeleted( Product $model )
	{
		//
	}
}
