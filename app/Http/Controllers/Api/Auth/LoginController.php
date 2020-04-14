<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends BaseController
{
	/**
	 * @param LoginRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function __invoke( LoginRequest $request )
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
			->createToken( config( 'app.name' ) );
		$auth->token->expires_at = Carbon::now()
			->addDay();
		
		$auth->token->save();
		
		return response()->json( [
			'token_type' => 'Bearer',
			'token'      => $auth->accessToken,
			'expires_at' => Carbon::parse( $auth->token->expires_at )
				->toDateTimeString(),
		],
			200 );
	}
}