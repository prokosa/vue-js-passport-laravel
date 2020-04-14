<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 01.10.19 14:54
 *  ****************************************************************************
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
			'parent_id'                => 'integer|nullable',
			'set_id'                   => 'array|required_without:parent_id',
			'set_id.*'                 => 'integer|required_without:parent_id',
			'building_id'              => 'integer|required_without:parent_id',
			'name'                     => 'string|max:250|required',
			'mark'                     => 'nullable|string|max:25',
			'sheets'                   => 'nullable|string|max:25',
			'date_transfer_production' => 'date|nullable',
			'edition'                  => 'required|integer|between:0,1000',
		];
	}
}
