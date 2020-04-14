<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 11.02.20 11:46
 *  ****************************************************************************
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
			'attachments'   => 'required|array|min:1',
			'attachments.*' => 'required|file|max:10240',
		];
	}
}