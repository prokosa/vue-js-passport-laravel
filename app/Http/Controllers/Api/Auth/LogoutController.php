<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LogoutController extends BaseController
{
	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function __invoke(Request $request)
	{
		$request->user()->token()->revoke();
		
		return response()->json([
			'message' => 'You are successfully logged out',
		]);
	}
}