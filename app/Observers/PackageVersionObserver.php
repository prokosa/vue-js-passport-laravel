<?php

namespace App\Observers;

use App\Models\PackageVersion;
use Illuminate\Support\Str;

class PackageVersionObserver
{
	/**
	 * Handle the package version "creating" event.
	 *
	 * @param  PackageVersion $model
	 *
	 * @return void
	 */
	public function creating( PackageVersion $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * @param PackageVersion $model
	 *
	 * @throws \Exception
	 */
	public function deleting( PackageVersion $model )
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
	 * @param  PackageVersion $model
	 *
	 * @return void
	 */
	public function restored( PackageVersion $model )
	{
		//
	}
	
	/**
	 * Handle the package version "force deleted" event.
	 *
	 * @param  PackageVersion $model
	 *
	 * @return void
	 */
	public function forceDeleted( PackageVersion $model )
	{
		//
	}
}
