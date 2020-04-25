<?php

namespace App\Observers;

use App\Models\PaymentSystem;

class PaymentSystemObserver
{
	/**
	 * Handle the set "creating" event.
	 *
	 * @param  PaymentSystem $model
	 *
	 * @return void
	 */
	public function creating( PaymentSystem $model )
	{
		$model->creator_id = auth()->user()->id;
	}
	
	/**
	 * @param PaymentSystem $model
	 */
	public function deleting( PaymentSystem $model )
	{
		$model->children()
			->delete();
	}
}
