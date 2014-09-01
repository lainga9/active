<?php namespace Services\Composers;

use User;
use Auth;

class SocialComposer {

	protected $user;

	public function __construct()
	{
		$this->user 	= Auth::user();
	}

	public function compose($view)
	{
		$view->with('user', $this->user);
	}

}