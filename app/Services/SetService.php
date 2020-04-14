<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 06.12.19 18:04
 *  ****************************************************************************
 */

namespace App\Services;

use App\Http\Requests\SetRequest;
use App\Models\Set;

class SetService
{
	/**
	 * @param SetRequest $request
	 *
	 * @return Set
	 */
	public function store( SetRequest $request )
	{
		$model = new Set;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Set        $set
	 * @param SetRequest $request
	 *
	 * @return mixed
	 */
	public function update( Set $set, SetRequest $request )
	{
		$model = Set::lockForUpdate()
			->find( $set->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Set $set
	 *
	 * @throws \Exception
	 */
	public function destroy( Set $set )
	{
		$set->delete();
	}
}