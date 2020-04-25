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

use App\Models\Role;
use App\Http\Requests\RoleRequest;

class RoleService
{
	/**
	 * @param RoleRequest $request
	 *
	 * @return Role
	 */
	public function store( RoleRequest $request )
	{
		$model = new Role;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Role        $group
	 * @param RoleRequest $request
	 *
	 * @return mixed
	 */
	public function update( Role $group, RoleRequest $request )
	{
		$model = Role::lockForUpdate()
			->find( $group->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Role $group
	 *
	 * @throws \Exception
	 */
	public function destroy( Role $group )
	{
		$group->delete();
	}
}