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
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
	/**
	 * @var UserService
	 */
	protected $userService;
	
	/**
	 * UserController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->userService = app( UserService::class );
	}
	
	/**
	 * @return UserResource
	 */
	public function index()
	{
		return new UserResource( User::all() );
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
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		return view( 'users.create' );
	}
	
	/**
	 * @param UserRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function store( UserRequest $request )
	{
		$data = DB::transaction( function () use ( $request ) {
			return $this->userService->store( $request );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param User $user
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function edit( User $user )
	{
		return view( 'users.edit' )
			->with( [ 'model' => $user ] )
			->render();
	}
	
	/**
	 * @param UserRequest $request
	 * @param User        $user
	 *
	 * @return \Illuminate\Http\JsonResponse|object
	 * @throws \Throwable
	 */
	public function update( UserRequest $request, User $user )
	{
		$data = DB::transaction( function () use ( $user, $request ) {
			return $this->userService->update( $user, $request );
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