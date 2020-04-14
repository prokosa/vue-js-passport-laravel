<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 29.09.19 14:07
 *  ****************************************************************************
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'parent_id' => 'integer|nullable',
			'name'      => 'required|string',
			'short'     => 'string|nullable',
			'order'     => 'string|nullable',
		];
		
		switch ( $this->getMethod() )
		{
			case 'POST':
				return $rules;
			case 'PUT':
				return $rules;
			case 'DELETE':
				return [
					'id' => 'required|integer|exists:sets,id',
				];
		}
	}
}
