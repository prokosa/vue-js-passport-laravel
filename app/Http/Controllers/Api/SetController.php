<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:38
 *  ****************************************************************************
 */

namespace App\Http\Controllers;

use App\Set;
use App\Http\Requests\SetRequest;
use App\Services\SetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Log;

class SetController extends BaseController
{
	/**
	 * @var SetService
	 */
	protected $setService;
	
	/**
	 * SetController constructor.
	 *
	 * @param SetService $set_service
	 */
	public function __construct( SetService $set_service )
	{
		parent::__construct();
		$this->setService = $set_service;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'sets.index' );
	}
	
	/**
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		$parents = Set::where( 'parent_id', null )
			->orderBy( 'name', 'asc' )
			->get();
		
		return view( 'sets.create' )
			->with( [
				'parents' => $parents,
			] )
			->render();
	}
	
	/**
	 * @param SetRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( SetRequest $request )
	{
		DB::enableQueryLog();
		$stored = DB::transaction( function () use ( $request ) {
			return $this->setService->store( $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $stored;
	}
	
	/**
	 * @param Set $set
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function edit( Set $set )
	{
		$parents = Set::where( 'parent_id', null )
			->where( 'id', '!=', $set->id )
			->orderBy( 'name', 'asc' )
			->get();
		
		return view( 'sets.edit' )
			->with( [
				'model'   => $set,
				'parents' => $parents,
			] )
			->render();
	}
	
	/**
	 * @param SetRequest $request
	 * @param Set        $set
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Throwable
	 */
	public function update( SetRequest $request, Set $set )
	{
		DB::enableQueryLog();
		$updated = DB::transaction( function () use ( $request, $set ) {
			return $this->setService->update( $set, $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $updated;
	}
	
	/**
	 * @param Set $set
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( Set $set )
	{
		return view( 'sets.delete' )
			->with( [
				'model' => $set,
			] )
			->render();
	}
	
	/**
	 * @param Set $set
	 *
	 * @throws \Throwable
	 */
	public function destroy( Set $set )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $set ) {
			$this->setService->destroy( $set );
		} );
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function table( Request $request )
	{
		$data = Set::with( 'parent' )
			->get();
		
		return Datatables::of( $data )
			->addColumn( 'action', 'datatable.sets.actions' )
			->editColumn( 'parent',
				function ( $data ) {
					if ( $data->parent )
					{
						return $data->parent->name;
					} else
					{
						return '';
					}
				} )
			->rawColumns( [ 'action' ] )
			->make( true );
	}
}
