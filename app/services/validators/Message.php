<?php namespace Services\Validators;

class Message extends Validator {

	public static $customMessages = [];

	public static $rules = array(
		'content'	=> 'required'
	);
}