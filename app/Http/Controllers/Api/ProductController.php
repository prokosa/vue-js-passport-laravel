<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 15.09.19 23:26
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

final class ProductController extends BaseController
{
	/**
	 * @var ProductService
	 */
	protected $productService;
	
	/**
	 * ProductController constructor.
	 *
	 * @param ProductService $product_service
	 */
	public function __construct( ProductService $product_service )
	{
		parent::__construct();
		$this->productService = $product_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return Product::paginate( 20 );
	}
	
	/**
	 * @param Product $product
	 *
	 * @return string
	 */
	public function show( Product $product )
	{
		return $product->toJson();
	}
	
	/**
	 * @param ProductRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( ProductRequest $request )
	{
		$stored = DB::transaction( function () use ( $request ) {
			return $this->productService->store( $request );
		} );
		
		return $stored;
	}
	
	/**
	 * @param ProductRequest $request
	 * @param Product        $product
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function update( ProductRequest $request, Product $product )
	{
		$updated = DB::transaction( function () use ( $product, $request ) {
			return $this->productService->update( $product, $request );
		} );
		
		return $updated;
	}
	
	/**
	 * @param Product $product
	 *
	 * @throws \Throwable
	 */
	public function destroy( Product $product )
	{
		DB::transaction( function () use ( $product ) {
			$this->productService->destroy( $product );
		} );
	}
}