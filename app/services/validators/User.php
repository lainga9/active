<?php namespace Services\Validators;

class User extends Validator {

	public static $customMessages = [];

	public static $rules = array(
		'first_name'=> 'required',
		'last_name' => 'required',
		'email' 	=> 'required|email|confirmed|unique:users',
		'password' 	=> 'required|confirmed',
		'user_type' => 'required',
		'dob_day' 	=> 'required',
		'dob_month' => 'required',
		'dob_year' 	=> 'required'
	);

	public static $updateRules = [];
}