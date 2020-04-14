<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreated extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;
	
	/**
	 * @var
	 */
	public $user;
	
	/**
	 * @var
	 */
	public $password;
	
	/**
	 * UserCreated constructor.
	 *
	 * @param User $user
	 * @param      $password
	 */
	public function __construct( User $user, $password )
	{
		$this->user     = $user;
		$this->password = $password;
	}
	
	/**
	 * @return UserCreated
	 */
	public function build()
	{
		return $this->view( 'emails.users.created' );
	}
}
