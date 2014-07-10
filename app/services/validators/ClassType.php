<?php namespace Services\Validators;

class ClassType extends Validator {

	public static $customMessages = [];

	public static $rules = array(
		'name'	=> 'required'
	);
}