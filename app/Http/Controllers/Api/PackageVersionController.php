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

use App\PackageVersion;
use App\Http\Requests\PackageVersionRequest;
use App\Services\PackageVersionService;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Log;

class PackageVersionController extends BaseController
{
	/**
	 * @var FileService
	 */
	protected $fileService;
	/**
	 * @var PackageVersionService
	 */
	protected $documentVersionService;
	
	/**
	 * PackageVersionController constructor.
	 *
	 * @param FileService           $file_service
	 * @param PackageVersionService $document_version_service
	 */
	public function __construct( FileService $file_service, PackageVersionService $document_version_service )
	{
		parent::__construct();
		$this->fileService            = $file_service;
		$this->documentVersionService = $document_version_service;
	}
	
	/**
	 * @param Document $document
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create( Document $document )
	{
		return view( 'documentation.documents.versions.create' )
			->with( [
				'document' => $document,
			] )
			->render();
	}
	
	/**
	 * @param PackageVersionRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( PackageVersionRequest $request )
	{
		DB::enableQueryLog();
		$stored = DB::transaction( function () use ( $request ) {
			$file_version = $this->fileService->verification( $request->file( 'file' ) );
			if ( $file_version )
			{
				$file = $file_version;
			} else
			{
				$file = $this->fileService->store( $request->file( 'file' ) );
			}
			
			$document = Document::find( $request->document_id );
			
			$model = $this->documentVersionService->store( $document, $file );
			
			return $model;
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return redirect()->route( 'documents.show', [
			'document' => $stored->document_id
		] );
	}
	
	/**
	 * @param PackageVersion $version
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( PackageVersion $version )
	{
		return view( 'documentation.documents.versions.delete' )
			->with( [
				'model' => $version,
			] )
			->render();
	}
	
	/**
	 * @param PackageVersion $version
	 *
	 * @throws \Throwable
	 */
	public function destroy( PackageVersion $version )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $version ) {
			$version->delete();
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
	}
	
	/**
	 * @param Document $document
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function table( Document $document )
	{
		$data = PackageVersion::with( 'file', 'creator' )
			->where( 'document_id', $document->id )
			->get();
		
		return Datatables::of( $data )
			->addColumn( 'action', 'datatable.documents.versions.actions' )
			->rawColumns( [ 'action' ] )
			->editColumn( 'author',
				function ( $data ) {
					return $data->creator->name;
				} )
			->make( true );
	}
	
	/**
	 * @param PackageVersion $version
	 *
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function download( PackageVersion $version )
	{
		return response()->download( Storage::disk( 'public' )
			->path( $version->file->path ),
			$version->file_name_for_download );
	}
}