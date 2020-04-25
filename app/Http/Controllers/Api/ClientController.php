<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

final class ClientController extends BaseController
{
	/**
	 * @return mixed
	 */
	public function index()
	{
		return Client::paginate( 20 );
	}
	
	/**
	 * @param Client $client
	 *
	 * @return ClientResource
	 */
	public function show( Client $client )
	{
		return new ClientResource( $client );
	}
	
	/**
	 * @param ClientRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function store( ClientRequest $request )
	{
		$validated = $request->validated();
		$data      = DB::transaction( function () use ( $validated ) {
			return $this->clientService->store( $validated );
		} );
		
		return response()->json( $data, 201 );
		
	}
	
	/**
	 * @param ClientRequest $request
	 * @param Client        $client
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function update( ClientRequest $request, Client $client )
	{
		$validated = $request->validated();
		
		$data = DB::transaction( function () use ( $client, $validated ) {
			return $this->clientService->update( $validated, $client );
		} );
		
		return response()->json( $data, 202 );
		
	}
	
	/**
	 * @param Client $client
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function destroy( Client $client )
	{
		DB::transaction( function () use ( $client ) {
			$this->clientService->destroy( $client );
		} );
		
		return response()->json( null, 204 );
		
	}
}
