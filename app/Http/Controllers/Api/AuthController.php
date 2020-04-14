<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\UserService;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AuthController extends BaseController
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
		$user             = $this->userService->store( $request );
		$success['token'] = $user->createToken('authToken')->accessToken;
		$success['name']  = $user->name;
		
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
		
		$auth                    = Auth::user()
			->createToken('authToken');
		$auth->token->expires_at = Carbon::now()
			->addDay();
		
		$auth->token->save();
		
		return response()->json( [
			'token_type' => 'Bearer',
			'authToken'      => $auth->accessToken,
			'expires_at' => Carbon::parse( $auth->token->expires_at )
				->toDateTimeString(),
		],
			200 );
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