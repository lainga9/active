<?php

class AuthController extends BaseController {

	protected $layout = 'layouts.login';

	public function register()
	{
		if( Auth::check() )
		{
			return Redirect::route('dashboard');
		}

		$this->layout->content = View::make('auth.register');
	}

	public function getLogin()
	{
		if( Auth::check() )
		{
			return Redirect::intended('/');
		}
		
		$this->layout->content = View::make('auth.register');
	}

	public function postLogin()
	{
		$userData = array(
			'email' 	=> Input::get('email'),
			'password' 	=> Input::get('password')
		);

		if(Auth::attempt($userData)) 
		{
			return Redirect::intended('/')
			->with('success', 'Thanks for logging in');
		} 
		else 
		{
			return Redirect::route('getLogin')
			->with('error', 'Incorrect login details');
		}
	}

	public function getLogout()
	{
		if(Auth::check()) 
		{
			Auth::logout();
			return Redirect::route('getLogin')
			->with('success', 'Logged out successfully.');
		} 
		else 
		{
			// If they're not logged in then redirect them to admin home
			return Redirect::to('/');
		}
	}

}
