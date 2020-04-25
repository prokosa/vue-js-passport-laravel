<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Support\Facades\DB;

final class RoleController extends BaseController
{
	/**
	 * @var RoleService
	 */
	protected $groupService;
	
	/**
	 * GroupController constructor.
	 *
	 * @param RoleService $group_service
	 */
	public function __construct( RoleService $group_service )
	{
		parent::__construct();
		$this->groupService = $group_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return Role::paginate( 20 );
	}
	
	/**
	 * @param Role $role
	 *
	 * @return RoleResource
	 */
	public function show( Role $role )
	{
		return new RoleResource( $role );
	}
	
	/**
	 * @param RoleRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( RoleRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->roleService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param RoleRequest $request
	 * @param Role        $role
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( RoleRequest $request, Role $role )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $role, $validated ) {
			return $this->roleService->update( $validated, $role );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param Role $role
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( Role $role )
	{
		DB::transaction( function () use ( $role ) {
			$this->roleService->destroy( $role );
		} );
		
		return response()->json( null, 204 );
		
	}

}
