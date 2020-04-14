<?php

namespace App\Jobs;

use App\Mail\UserCreated;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;


class SendAuthDataJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	/**
	 * @var
	 */
	protected $password;
	
	/**
	 * @var
	 */
	protected $user;
	
	/**
	 * SendAuthDataJob constructor.
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
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$email = new UserCreated( $this->user, $this->password );
		Mail::to($this->user->email)->send($email);
	}
}
