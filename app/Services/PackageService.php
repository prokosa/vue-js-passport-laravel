<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 31.01.20 20:45
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\Family;
use App\Models\Package;
use App\Http\Requests\PackageRequest;

class PackageService
{
	/**
	 * @param PackageRequest $request
	 *
	 * @return Package
	 */
	public function store( PackageRequest $request )
	{
		$model = new Package;
		$model->fill( $request->all() );
		$model->save();
		
		if ( $request->parent_id )
		{
			$parent = Family::find( $request->parent_id );
			$parent->appendNode( $model );
		}
		
		return $model;
	}
	
	/**
	 * @param Package        $package
	 * @param PackageRequest $request
	 *
	 * @return mixed
	 */
	public function update( Package $package, PackageRequest $request )
	{
		$model = Package::lockForUpdate()
			->find( $package->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Package $package
	 *
	 * @throws \Exception
	 */
	public function destroy( Package $package )
	{
		$package->delete();
	}
}