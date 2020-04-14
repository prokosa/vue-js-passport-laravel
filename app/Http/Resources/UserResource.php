<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray( $request )
	{
		return $this->resource->map( function ( $item ) {
			return [
				'id'            => $item->id,
				'name'          => $item->name,
				'email'         => $item->email,
				'register_date' => (string) $item->created_at,
			];
		} );
	}
}
