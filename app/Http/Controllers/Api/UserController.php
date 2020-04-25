<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 14.09.19 22:43
 *  ****************************************************************************
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

final class UserController extends BaseController
{
	/**
	 * @var UserService
	 */
	protected $userService;
	
	/**
	 * UserController constructor.
	 *
	 * @param UserService $user_service
	 */
	public function __construct( UserService $user_service )
	{
		parent::__construct();
		$this->userService = $user_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return User::paginate( 20 );
	}
	
	/**
	 * @param User $user
	 *
	 * @return UserResource
	 */
	public function show( User $user )
	{
		return new UserResource( $user );
	}
	
	/**
	 * @return UserResource
	 */
	public function current()
	{
		return new UserResource( Auth::user() );
	}
	
	/**
	 * @param UserRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( UserRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->userService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param UserRequest $request
	 * @param User        $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( UserRequest $request, User $user )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $user, $validated ) {
			return $this->userService->update( $validated, $user );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param User $user
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( User $user )
	{
		DB::transaction( function () use ( $user ) {
			$this->userService->destroy( $user );
		} );
		
		return response()->json( null, 204 );
		
	}
}