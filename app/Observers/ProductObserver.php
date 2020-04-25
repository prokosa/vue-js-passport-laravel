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

use App\Models\Region;
use Illuminate\Support\Str;

class ProductObserver
{
	/**
	 * Handle the package version "creating" event.
	 *
	 * @param  Region $model
	 *
	 * @return void
	 */
	public function creating( Region $model )
	{
		$model->creator_id = auth()->user()->id;
		$model->key        = (string) Str::uuid();
	}
	
	/**
	 * @param Region $model
	 *
	 * @throws \Exception
	 */
	public function deleting( Region $model )
	{
		$model->file()->delete();
	}
}