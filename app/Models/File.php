<?php
/**
 * *****************************************************************************
 *  *Created by Prokosa Vyacheslav
 *  *Developer: Prokosa Vyacheslav <pokosa.v@gmail.com>
 *  *Copyright (c) Prokosa Vyacheslav 2019
 *  *Last modified 17.09.19 12:11
 *  ****************************************************************************
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
	use SoftDeletes;
	
	/**
	 * @var string
	 */
	protected $table = 'files';
	
	/**
	 * @var array
	 */
	protected $appends = [
		'full_name',
	];
	
	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'extension',
		'hash_sha256',
		'mime_type',
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
	public function creator()
	{
		return $this->belongsTo( User::class, 'creator_id' )
			->withTrashed();
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	 public function rfa_versions()
	 {
	 	return $this->hasMany( Region::class);
	 }
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_library()
	{
		return $this->hasMany( Order::class,'library_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_properties()
	{
		return $this->hasMany( Order::class,'properties_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_image()
	{
		return $this->hasMany( Order::class,'image_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_size_table()
	{
		return $this->hasMany( Order::class,'size_table_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_search_table()
	{
		return $this->hasMany( Order::class,'search_table_id' );
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function package_v_description()
	{
		return $this->hasMany( Order::class,'description_id' );
	}
	
	//--------------------Custom Attributes--------------------//
	
	/**
	 * @return string
	 */
	public function getPathAttribute()
	{
		return 'docs/' . $this->name . '.' . $this->extension;
	}
	
	/**
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->name . '.' . $this->extension;
	}
	
	/**
	 * @return string
	 */
	public static function dir()
	{
		return 'docs';
	}
	
	/**
	 * @return string
	 */
	public static function tmp()
	{
		return 'tmp';
	}
}
