<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 12.03.20 10:50
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\Group;
use App\Http\Requests\GroupRequest;

class GroupService
{
	/**
	 * @param GroupRequest $request
	 *
	 * @return Group
	 */
	public function store( GroupRequest $request )
	{
		$model = new Group;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Group        $group
	 * @param GroupRequest $request
	 *
	 * @return mixed
	 */
	public function update( Group $group, GroupRequest $request )
	{
		$model = Group::lockForUpdate()
			->find( $group->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Group $group
	 *
	 * @throws \Exception
	 */
	public function destroy( Group $group )
	{
		$group->delete();
	}
}