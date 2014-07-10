<?php namespace Services\Validators;

class Activity extends Validator {

	public static $customMessages = [];

	public static $rules = array(
		'name'	=> 'required',
		'description' => 'required',
		'places' => 'required|numeric',
		'cost' => 'required|numeric',
		'street_address' => 'required',
		'town' => 'required',
		'postcode' => 'required',
		'date' => 'required|future|date_format:Y-m-d',
		'time_from' => 'required',
		'time_until' => 'required'
	);
}