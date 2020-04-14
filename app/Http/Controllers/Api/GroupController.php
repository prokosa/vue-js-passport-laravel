<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupRequest;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Log;

class GroupController extends BaseController
{
	/**
	 * @var GroupService
	 */
	protected $groupService;
	
	/**
	 * GroupController constructor.
	 *
	 * @param GroupService $group_service
	 */
	public function __construct( GroupService $group_service )
	{
		parent::__construct();
		$this->groupService = $group_service;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'groups.index' );
	}
	
	/**
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		$parents = Group::where( 'parent_id', null )
			->orderBy( 'name', 'asc' )
			->get();
		
		return view( 'groups.create' )
			->with( [
				'parents' => $parents,
			] )
			->render();
	}
	
	/**
	 * @param GroupRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( GroupRequest $request )
	{
		DB::enableQueryLog();
		$stored = DB::transaction( function () use ( $request ) {
			return $this->groupService->store( $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $stored;
	}
	
	/**
	 * @param Group $group
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function edit( Group $group )
	{
		$parents = Group::where( 'parent_id', null )
			->where( 'id', '!=', $group->id )
			->orderBy( 'name', 'asc' )
			->get();
		
		return view( 'groups.edit' )
			->with( [
				'model'   => $group,
				'parents' => $parents,
			] )
			->render();
	}
	
	/**
	 * @param GroupRequest $request
	 * @param Group              $group
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function update( GroupRequest $request, Group $group )
	{
		DB::enableQueryLog();
		$updated = DB::transaction( function () use ( $group, $request ) {
			return $this->groupService->update( $group, $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $updated;
	}
	
	/**
	 * @param Group $group
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( Group $group )
	{
		return view( 'groups.delete' )
			->with( [
				'model' => $group,
			] )
			->render();
	}
	
	/**
	 * @param Group $group
	 *
	 * @throws \Throwable
	 */
	public function destroy( Group $group )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $group ) {
			$this->groupService->destroy( $group );
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
		$data = Group::with( 'organization')->get();
		
		return Datatables::of( $data )
			->addColumn( 'action', 'datatable.groups.actions' )
			->editColumn( 'organization',
				function ( $data ) {
					if ( $data->organization )
					{
						return $data->organization->name;
					} else
					{
						return '';
					}
				} )
			->rawColumns( [ 'action' ] )
			->make( true );
	}

}
