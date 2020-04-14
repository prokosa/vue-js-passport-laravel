<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 15.09.19 23:26
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\Http\Requests\PackageRequest;
use App\Package;
use App\Services\PackageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Log;

class PackageController extends BaseController
{
	/**
	 * @var PackageService
	 */
	protected $packageService;
	
	/**
	 * PackageController constructor.
	 *
	 * @param PackageService $package_service
	 */
	public function __construct( PackageService $package_service )
	{
		parent::__construct();
		$this->packageService = $package_service;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'packages.index' );
	}
	
	/**
	 * @param Package $package
	 *
	 * @return string
	 */
	public function show( Package $package )
	{
		return $package->toJson();
	}
	
	/**
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		return view( 'packages.create' )
			->render();
	}
	
	/**
	 * @param PackageRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( PackageRequest $request )
	{
		DB::enableQueryLog();
		$stored = DB::transaction( function () use ( $request ) {
			return $this->packageService->store( $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $stored;
	}
	
	/**
	 * @param Package $package
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function edit( Package $package )
	{
		return view( 'packages.edit' )
			->with( [
				'model' => $package,
			] )
			->render();
	}
	
	/**
	 * @param PackageRequest $request
	 * @param Package        $package
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function update( PackageRequest $request, Package $package )
	{
		DB::enableQueryLog();
		$updated = DB::transaction( function () use ( $package, $request ) {
			return $this->packageService->update( $package, $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $updated;
	}
	
	/**
	 * @param Package $package
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( Package $package )
	{
		return view( 'packages.delete' )
			->with( [
				'model' => $package,
			] )
			->render();
	}
	
	/**
	 * @param Package $package
	 *
	 * @throws \Throwable
	 */
	public function destroy( Package $package )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $package ) {
			$this->packageService->destroy( $package );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function table( Request $request )
	{
		$data = Package::all();
		
		return Datatables::of( $data )
			->addColumn( 'action', 'datatable.packages.actions' )
			->addColumn( 'name_colored', 'datatable.packages.name' )
			->addColumn( 'status_action', 'datatable.packages.status' )
			->addColumn( 'sets_string',
				function ( $data ) {
					$sets = $data->sets->pluck( 'short' )
						->toArray();
					
					return implode( ', ', $sets );
				} )
			->editColumn( 'building',
				function ( $data ) {
					return $data->building->full_name;
				} )
			->rawColumns( [ 'action', 'name_colored', 'status_action', 'sets_string' ] )
			->make( true );
	}
}