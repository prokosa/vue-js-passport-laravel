<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 31.01.20 20:45
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductService
{
	/**
	 * @param ProductRequest $request
	 *
	 * @return Product
	 */
	public function store( ProductRequest $request )
	{
		$model = new Product;
		$model->fill( $request->all() );
		$model->save();
		
		if ( $request->parent_id )
		{
			$parent = Category::find( $request->parent_id );
			$parent->appendNode( $model );
		}
		
		return $model;
	}
	
	/**
	 * @param Product        $package
	 * @param ProductRequest $request
	 *
	 * @return mixed
	 */
	public function update( Product $package, ProductRequest $request )
	{
		$model = Product::lockForUpdate()
			->find( $package->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Product $package
	 *
	 * @throws \Exception
	 */
	public function destroy( Product $package )
	{
		$package->delete();
	}
}