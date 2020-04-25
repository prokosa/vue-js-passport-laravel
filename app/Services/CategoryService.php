<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 11.12.19 17:58
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\Category;

class CategoryService
{
	/**
	 * @param array $data
	 *
	 * @return Category
	 */
	public function store( array $data ): Category
	{
		$model = new Category;
		$model->fill( $data );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param array    $data
	 * @param Category $category
	 *
	 * @return Category
	 */
	public function update( array $data, Category $category ): Category
	{
		$model = Category::lockForUpdate()
			->find( $category->id );
		$model->fill( $data );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param Category $category
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function destroy( Category $category ): bool
	{
		return $category->delete();
	}
}