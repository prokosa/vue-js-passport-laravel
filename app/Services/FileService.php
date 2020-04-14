<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 20.09.19 14:45
 *  ****************************************************************************
 */

namespace App\Services;

use App\Models\File;
use App\Http\Requests\FileRequest;


class FileService
{
	/**
	 * @param FileRequest $request
	 *
	 * @return File
	 */
	public function store( FileRequest $request )
	{
		$model = new File;
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param File        $file
	 * @param FileRequest $request
	 *
	 * @return mixed
	 */
	public function update( File $file, FileRequest $request )
	{
		$model = File::lockForUpdate()
			->find( $file->id );
		$model->fill( $request->all() );
		$model->save();
		
		return $model;
	}
	
	/**
	 * @param File $file
	 *
	 * @return bool|null
	 * @throws \Exception
	 */
	public function destroy( File $file )
	{
		return $file->delete();
	}
}