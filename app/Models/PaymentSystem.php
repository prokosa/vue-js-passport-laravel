<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:38
 *  ****************************************************************************
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentSystem extends Model
{
	use SoftDeletes;
	
	/**
	 * @var string
	 */
	protected $table = 'sets';
	
	/**
	 * @var array
	 */
	protected $fillable = [
		'parent_id',
		'name',
		'order',
		'short',
	];
	
	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'created_at' => 'datetime:Y-m-d',
		'updated_at' => 'datetime:Y-m-d',
	];
	/**
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	
	
	//--------------------Relationships--------------------//
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function families()
	{
		return $this->belongsToMany( Category::class, 'family_set', 'set_id', 'family_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function parent()
	{
		return $this->belongsTo( self::class, 'parent_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function children()
	{
		return $this->hasMany( self::class, 'parent_id' );
	}
	
	/**
	 * @return mixed
	 */
	public function creator()
	{
		return $this->belongsTo( User::class, 'creator_id' )
			->withTrashed();
	}
}