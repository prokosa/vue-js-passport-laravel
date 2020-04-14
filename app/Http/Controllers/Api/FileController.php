<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:11
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\FileRequest;
use App\Services\FileService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Log;

class FileController extends BaseController
{
	/**
	 * @var FileService
	 */
	protected $fileService;
	
	/**
	 * PackageVersionController constructor.
	 *
	 * @param FileService $file_service
	 */
	public function __construct( FileService $file_service )
	{
		parent::__construct();
		$this->fileService = $file_service;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'documentation.files.index' );
	}
	
	/**
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		return view( 'documentation.files.create' )->render();
	}
	
	/**
	 * @param FileRequest $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Throwable
	 */
	public function store( FileRequest $request )
	{
		$response_array = [];
		foreach ( $request->attachments as $attachment )
		{
			$original_name = pathinfo( $attachment->getClientOriginalName(), PATHINFO_FILENAME );
			$file_exist    = $this->fileService->verification( $attachment );
			
			if ( $file_exist )
			{
				$user_has = $this->user->files->where( 'id', $file_exist->id )
					->first();
				
				if ( !$user_has )
				{
					$user_file = DB::transaction( function () use ( $file_exist, $original_name ) {
						return $this->fileService->attachFileToUser( $this->user, $file_exist, $original_name );
					} );
				} else
				{
					$user_file = [
						'file'          => $user_has,
						'original_name' => $original_name,
					];
				}
			} else
			{
				$user_file = DB::transaction( function () use ( $attachment, $original_name ) {
					$file = $this->fileService->store( $attachment );
					
					return $this->fileService->attachFileToUser( $this->user, $file, $original_name );
				} );
			}
			$response_array[] = $user_file;
		}
		
		return view( 'documentation.files.result' )->with( [
			'response_array' => $response_array,
		] );
	}
	
	/**
	 * @param File $file
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( File $file )
	{
		return view( 'documentation.files.delete' )
			->with( [
				'model' => $this->user->files->where( 'id', $file->id )
					->first(),
			] )
			->render();
	}
	
	/**
	 * @param File $file
	 *
	 * @throws \Throwable
	 */
	public function destroy( File $file )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $file ) {
			$this->user->files()->detach($file);
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
	}
	
	/**
	 * @return mixed
	 * @throws \Exception
	 */
	public function table()
	{
		$data = $this->user->files;
		
		return Datatables::of( $data )
			->addColumn( 'action', 'datatable.files.actions' )
			->addColumn( 'original_name',
				function ( $data ) {
					return $data->pivot->original_name;
				} )
			->rawColumns( [ 'action', 'original_name' ] )
			->make( true );
	}
	
	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function show( Request $request )
	{
		$see_url = $this->fileService->seeLinkByFileName( $request->name );
		
		return response()->redirectTo( $see_url . '?uid=' . $this->user->key );
	}
}
