<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 23.09.19 1:24
 *  ****************************************************************************
 */

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

final class UserRequest extends FormRequest
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
			'name' => 'required|max:120',
		];
		
		switch ( $this->getMethod() )
		{
			case 'POST':
				return $rules + [ 'email' => 'required|email|unique:users' ];
			case 'PUT':
				return $rules + [ 'email' => 'required|email|unique:users,email,' . $this->user->id ];
		}
	}
}
