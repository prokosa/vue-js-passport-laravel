<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 15.09.19 23:26
 *  ****************************************************************************
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;

final class CategoryController extends BaseController
{
	/**
	 * @var CategoryService
	 */
	protected $categoryService;
	
	/**
	 * CategoryController constructor.
	 *
	 * @param CategoryService $category_service
	 */
	public function __construct( CategoryService $category_service )
	{
		parent::__construct();
		$this->categoryService = $category_service;
	}
	
	/**
	 * @return mixed
	 */
	public function index()
	{
		return Category::paginate( 20 );
	}
	
	/**
	 * @param Category $category
	 *
	 * @return CategoryResource
	 */
	public function show( Category $category )
	{
		return new CategoryResource( $category );
	}
	
	/**
	 * @param CategoryRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( CategoryRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->categoryService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param CategoryRequest $request
	 * @param Category        $category
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( CategoryRequest $request, Category $category )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $category, $validated ) {
			return $this->categoryService->update( $validated, $category );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param Category $category
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( Category $category )
	{
		DB::transaction( function () use ( $category ) {
			$this->categoryService->destroy( $category );
		} );
		
		return response()->json( null, 204 );
		
	}
}
