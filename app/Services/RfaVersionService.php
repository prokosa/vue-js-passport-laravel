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

use App\Models\RfaVersion;
use App\Models\Package;
use App\Models\File;

class RfaVersionService
{
	/**
	 * @param Package $model
	 * @param File    $file
	 *
	 * @return RfaVersion
	 */
	public function store( Package $model, File $file )
	{
		$version             = new RfaVersion;
		$version->package_id = $model->id;
		$version->file_id    = $file->id;
		$version->version    = $model->rfa_versions()
				->withTrashed()
				->max( 'version' ) + 1;
		$version->save();
		
		return $version;
	}
	
	/**
	 * @param RfaVersion $version
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy( RfaVersion $version )
	{
		return $version->delete();
	}
}