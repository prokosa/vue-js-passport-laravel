<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 06.12.19 18:04
 *  ****************************************************************************
 */

namespace App\Services;

use App\Http\Requests\PaymentSystemRequest;
use App\Models\PaymentSystem;

class PaymentSystemService
{
	/**
	 * @param PaymentSystemRequest $request
	 *
	 * @return PaymentSystem
	 */
	public function store( PaymentSystemRequest $request )
	{
		$model = new PaymentSystem;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param PaymentSystem        $set
	 * @param PaymentSystemRequest $request
	 *
	 * @return mixed
	 */
	public function update( PaymentSystem $set, PaymentSystemRequest $request )
	{
		$model = PaymentSystem::lockForUpdate()
			->find( $set->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param PaymentSystem $set
	 *
	 * @throws \Exception
	 */
	public function destroy( PaymentSystem $set )
	{
		$set->delete();
	}
}