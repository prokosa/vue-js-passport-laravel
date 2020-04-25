<?php

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class RequestUserData extends DataTransferObject
{
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $email;
	
	/**
	 * @var string
	 */
	public $password;
}