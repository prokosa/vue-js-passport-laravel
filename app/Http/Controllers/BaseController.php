<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 21.02.19 13:43
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
	/**
	 * @var \App\User|\Illuminate\Contracts\Auth\Authenticatable|null
	 */
	protected $user;
	
	/**
	 * BaseController constructor.
	 */
	public function __construct()
	{
		$this->middleware( function ( $request, $next ) {
			$this->user = Auth::user();
			return $next( $request );
		} );
	}
	
	/**
	 * @param     $result
	 * @param     $message
	 * @param int $status
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sendResponse( $result, $message, $status = 200 )
	{
		$response = [
			'success' => true,
			'data'    => $result,
			'message' => $message,
		];
		
		return response()->json( $response, $status );
	}
	
	/**
	 * @param       $error
	 * @param array $errorMessages
	 * @param int   $status
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sendError( $error, $errorMessages = [], $status = 404 )
	{
		$response = [
			'success' => false,
			'message' => $error,
		];
		if ( !empty( $errorMessages ) )
		{
			$response['data'] = $errorMessages;
		}
		
		return response()->json( $response, $status );
	}
	
}
