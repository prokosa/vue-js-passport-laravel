<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 29.09.19 13:24
 *  ****************************************************************************
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
			'name'      => 'string|required|unique:groups',
			'parent_id' => 'integer|nullable',
			'status'    => 'sometimes|in:1,0',
		];
		
		switch ( $this->getMethod() )
		{
			case 'POST':
				return $rules;
			case 'PUT':
				return $rules;
			case 'DELETE':
				return [
					'id' => 'required|integer|exists:groups,id',
				];
		}
	}
}
