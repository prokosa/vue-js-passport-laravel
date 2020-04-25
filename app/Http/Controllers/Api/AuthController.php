<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\UserService;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Auth;

final class AuthController extends BaseController
{
	/**
	 * @var UserService
	 */
	protected $userService;
	
	/**
	 * RegisterController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->userService = app( UserService::class );
	}
	
	/**
	 * @param RegisterRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function register( RegisterRequest $request )
	{
		$validated               = $request->validated();
		$user                    = $this->userService->store( $validated );
		$success['access_token'] = $user->createToken( 'authToken' )->accessToken;
		$success['name']         = $user->name;
		
		return $this->sendResponse( $success, 'User register successfully.' );
	}
	
	/**
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login( LoginRequest $request )
	{
		if ( !Auth::attempt( $request->all() ) )
		{
			return $this->sendError(
				'You cannot sign with those credentials',
				'Unauthorised',
				401
			);
		}
		
		$accessToken = Auth::user()
			->createToken( 'authToken' )->accessToken;
		
		return response( [
			'user'         => Auth::user(),
			'access_token' => $accessToken,
		] );
	}
	
	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout( Request $request )
	{
		$request->user()
			->token()
			->revoke();
		
		return response()->json( [
			'message' => 'You are successfully logged out',
		] );
	}
}