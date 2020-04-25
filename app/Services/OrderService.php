<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.02.20 19:12
 *  ****************************************************************************
 */

namespace App\Services;


use App\Models\Product;
use App\Models\Order;
use App\Models\File;

class OrderService
{
	/**
	 * @param Product $model
	 * @param File    $file
	 *
	 * @return Order
	 */
	public function store( Product $model, File $file )
	{
		$version             = new Order;
		$version->package_id = $model->id;
		$version->file_id    = $file->id;
		
		$version->save();
		
		return $version;
	}
	
	/**
	 * @param Order $version
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy( Order $version )
	{
		return $version->delete();
	}
}