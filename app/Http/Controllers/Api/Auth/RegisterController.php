<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\UserService;

class RegisterController extends BaseController
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
	public function __invoke( RegisterRequest $request )
	{
		$user             = $this->userService->store( $request );
		$success['token'] = $user->createToken( config( 'app.name' ))->accessToken;
		$success['name']  = $user->name;
		
		return $this->sendResponse( $success, 'User register successfully.' );
	}
}