<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 30.09.19 19:51
 *  ****************************************************************************
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
		return [
			'parent_id'        => 'integer|nullable',
			'name'             => 'string|nullable',
			'number'           => 'required|integer|between:1,1000000',
			'additional'       => 'string|nullable',
			'address'          => 'string|nullable',
			'working_name'     => 'required_without:parent_id',
			'building_type_id' => 'integer|required',
		];
	}
}
