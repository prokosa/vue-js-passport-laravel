<?php

namespace App\Observers;

use App\Models\Package;
use Illuminate\Support\Str;

class PackageObserver
{
	/**
	 * Handle the package "creating" event.
	 *
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function creating( Package $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * Handle the package "saved" event.
	 *
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function saved( Package $model )
	{
		//
	}
	
	/**
	 * Handle the package "deleting" event.
	 *
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function deleting( Package $model )
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
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function deleted( Package $model )
	{
		//
	}
	
	/**
	 * Handle the package "restored" event.
	 *
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function restored( Package $model )
	{
		//
	}
	
	/**
	 * Handle the package "force deleted" event.
	 *
	 * @param  Package $model
	 *
	 * @return void
	 */
	public function forceDeleted( Package $model )
	{
		//
	}
}
