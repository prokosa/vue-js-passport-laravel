<?php

namespace App\Observers;

use App\Models\File;
use Illuminate\Support\Str;

class FileObserver
{
	/**
	 * Handle the file type "creating" event.
	 *
	 * @param  File $model
	 *
	 * @return void
	 */
	public function creating( File $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->name       = (string) Str::uuid();
	}
	
	/**
	 * Handle the file "updated" event.
	 *
	 * @param  File $model
	 *
	 * @return void
	 */
	public function updated( File $model )
	{
		//
	}
	
	/**
	 * Handle the file "deleted" event.
	 *
	 * @param  File $model
	 *
	 * @return void
	 */
	public function deleted( File $model )
	{
		//
	}
	
	/**
	 * Handle the file "restored" event.
	 *
	 * @param  File $model
	 *
	 * @return void
	 */
	public function restored( File $model )
	{
		//
	}
	
	/**
	 * Handle the file "force deleted" event.
	 *
	 * @param  File $model
	 *
	 * @return void
	 */
	public function forceDeleted( File $model )
	{
		//
	}
}
