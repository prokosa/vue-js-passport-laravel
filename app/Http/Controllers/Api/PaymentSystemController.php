<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:38
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\Models\PaymentSystem;
use App\Http\Requests\PaymentSystemRequest;
use App\Services\PaymentSystemService;
use Illuminate\Support\Facades\DB;

final class PaymentSystemController extends BaseController
{
	/**
	 * @var PaymentSystemService
	 */
	protected $paymentSystemService;
	
	/**
	 * PaymentSystemController constructor.
	 *
	 * @param PaymentSystemService $payment_system_service
	 */
	public function __construct( PaymentSystemService $payment_system_service )
	{
		parent::__construct();
		$this->paymentSystemService = $payment_system_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return PaymentSystem::paginate( 20 );
	}
	
	/**
	 * @param PaymentSystem $payment_system
	 *
	 * @return PaymentSystemResource
	 */
	public function show( PaymentSystem $payment_system )
	{
		return new PaymentSystemResource( $payment_system );
	}
	
	/**
	 * @param PaymentSystemRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( PaymentSystemRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->payment_systemService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param PaymentSystemRequest $request
	 * @param PaymentSystem        $payment_system
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( PaymentSystemRequest $request, PaymentSystem $payment_system )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $payment_system, $validated ) {
			return $this->payment_systemService->update( $validated, $payment_system );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param PaymentSystem $payment_system
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( PaymentSystem $payment_system )
	{
		DB::transaction( function () use ( $payment_system ) {
			$this->payment_systemService->destroy( $payment_system );
		} );
		
		return response()->json( null, 204 );
		
	}
}
