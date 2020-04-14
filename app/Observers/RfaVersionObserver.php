<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.03.20 23:55
 *  ****************************************************************************
 *
 */

namespace App\Observers;

use App\Models\RfaVersion;
use Illuminate\Support\Str;

class RfaVersionObserver
{
	/**
	 * Handle the package version "creating" event.
	 *
	 * @param  RfaVersion $model
	 *
	 * @return void
	 */
	public function creating( RfaVersion $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * @param RfaVersion $model
	 *
	 * @throws \Exception
	 */
	public function deleting( RfaVersion $model )
	{
		$model->file()->delete();
	}
}