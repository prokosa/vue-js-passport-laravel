<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:11
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class OrderController extends BaseController
{
	/**
	 * @var OrderService
	 */
	protected $orderService;
	
	/**
	 * OrderController constructor.
	 *
	 * @param OrderService $order_service
	 */
	public function __construct(OrderService $order_service )
	{
		parent::__construct();
		$this->orderService = $order_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return Order::paginate( 20 );
	}
	
	/**
	 * @param Order $order
	 *
	 * @return OrderResource
	 */
	public function show( Order $order )
	{
		return new OrderResource( $order );
	}
	
	/**
	 * @param OrderRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( OrderRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->orderService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param OrderRequest $request
	 * @param Order        $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( OrderRequest $request, Order $order )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $order, $validated ) {
			return $this->orderService->update( $validated, $order );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( Order $order )
	{
		DB::transaction( function () use ( $order ) {
			$this->orderService->destroy( $order );
		} );
		
		return response()->json( null, 204 );
		
	}
}