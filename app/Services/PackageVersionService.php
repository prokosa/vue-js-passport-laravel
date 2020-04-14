<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.02.20 19:12
 *  ****************************************************************************
 */

namespace App\Services;


use App\Models\Package;
use App\Models\PackageVersion;
use App\Models\File;

class PackageVersionService
{
	/**
	 * @param Package $model
	 * @param File    $file
	 *
	 * @return PackageVersion
	 */
	public function store( Package $model, File $file )
	{
		$version             = new PackageVersion;
		$version->package_id = $model->id;
		$version->file_id    = $file->id;
		
		$version->save();
		
		return $version;
	}
	
	/**
	 * @param PackageVersion $version
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy( PackageVersion $version )
	{
		return $version->delete();
	}
}