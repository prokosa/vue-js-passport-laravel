<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 19:11
 *  ****************************************************************************
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Family extends Model
{
	use SoftDeletes, NodeTrait;
	
	/**
	 * @var string
	 */
	protected $table = 'families';
	
	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'system',
		'status',
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
	public function sets()
	{
		return $this->belongsToMany( Set::class, 'family_set', 'family_id', 'set_id' );
	}
	
	/**
	 * @return mixed
	 */
	public function creator()
	{
		return $this->belongsTo( User::class, 'creator_id' )
			->withTrashed();
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function packages()
	{
		return $this->hasMany( Package::class);
	}
}
