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

namespace App\Services;

use App\Models\Region;
use App\Models\Product;
use App\Models\File;

class RegionService
{
	/**
	 * @param Product $model
	 * @param File    $file
	 *
	 * @return Region
	 */
	public function store( Product $model, File $file )
	{
		$version             = new Region;
		$version->package_id = $model->id;
		$version->file_id    = $file->id;
		$version->version    = $model->rfa_versions()
				->withTrashed()
				->max( 'version' ) + 1;
		$version->save();
		
		return $version;
	}
	
	/**
	 * @param Region $version
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy( Region $version )
	{
		return $version->delete();
	}
}