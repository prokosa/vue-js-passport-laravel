<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 24.03.20 23:48
 *  ****************************************************************************
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfaVersion extends Model
{
	use SoftDeletes;
	
	/**
	 * @var string
	 */
	protected $table = 'rfa_versions';
	
	/**
	 * @var array
	 */
	protected $fillable = [
		'package_id',
		'file_id',
		'version',
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
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function package()
	{
		return $this->belongsTo( Package::class );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function file()
	{
		return $this->belongsTo( File::class);
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator()
	{
		return $this->belongsTo( User::class, 'creator_id' )
			->withTrashed();
	}
	
}