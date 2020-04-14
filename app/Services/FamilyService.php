<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 11.12.19 17:58
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\Family;
use App\Http\Requests\FamilyRequest;

class FamilyService
{
	/**
	 * @param FamilyRequest $request
	 *
	 * @return Family
	 */
	public function store( FamilyRequest $request )
	{
		$model = new Family;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Family        $family
	 * @param FamilyRequest $request
	 *
	 * @return mixed
	 */
	public function update( Family $family, FamilyRequest $request )
	{
		$model = Family::lockForUpdate()
			->find( $family->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Family $family
	 *
	 * @throws \Exception
	 */
	public function destroy( Family $family )
	{
		$family->delete();
	}
}