<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 15.09.19 23:26
 *  ****************************************************************************
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Family;
use App\Services\FamilyService;
use App\Http\Requests\FamilyRequest;
use Illuminate\Support\Facades\DB;
use Log;

class FamilyController extends BaseController
{
	/**
	 * @var FamilyService
	 */
	protected $familyService;
	
	/**
	 * FamilyController constructor.
	 *
	 * @param FamilyService $family_service
	 */
	public function __construct( FamilyService $family_service )
	{
		parent::__construct();
		$this->familyService = $family_service;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		return view( 'families.index' );
	}
	
	/**
	 * @param Family $family
	 *
	 * @return string
	 */
	public function show( Family $family )
	{
		return $family->toJson();
	}
	
	/**
	 * @return array|string
	 * @throws \Throwable
	 */
	public function create()
	{
		return view( 'families.create' )
			->render();
	}
	
	/**
	 * @param FamilyRequest $request
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function store( FamilyRequest $request )
	{
		DB::enableQueryLog();
		$stored = DB::transaction( function () use ( $request ) {
			return $this->familyService->store( $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $stored;
	}
	
	/**
	 * @param Family $family
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function edit( Family $family )
	{
		$parents = Family::where( 'parent_id', null )
			->where( 'id', '!=', $family->id )
			->orderBy( 'full_name', 'asc' )
			->get();
		
		return view( 'families.edit' )
			->with( [
				'model'   => $family,
				'parents' => $parents,
			] )
			->render();
	}
	
	/**
	 * @param FamilyRequest $request
	 * @param Family        $family
	 *
	 * @return mixed
	 * @throws \Throwable
	 */
	public function update( FamilyRequest $request, Family $family )
	{
		DB::enableQueryLog();
		$updated = DB::transaction( function () use ( $request, $family ) {
			return $this->familyService->update( $family, $request );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
		
		return $updated;
	}
	
	/**
	 * @param Family $family
	 *
	 * @return array|string
	 * @throws \Throwable
	 */
	public function deleteQuestion( Family $family )
	{
		return view( 'families.delete' )
			->with( [
				'model' => $family,
			] )
			->render();
	}
	
	/**
	 * @param Family $family
	 *
	 * @throws \Throwable
	 */
	public function destroy( Family $family )
	{
		DB::enableQueryLog();
		DB::transaction( function () use ( $family ) {
			$this->familyService->destroy( $family );
		} );
		
		Log::info( 'query status',
			[
				'log' => DB::getQueryLog(),
			] );
	}
}
