<?php namespace Services\Validators;

abstract class Validator {
	
	protected $attributes;
	protected $update;
	protected $customRules;
	public $errors;

	public function __construct($attributes = null, $update = false, $customRules = null) {
		$this->attributes 	= $attributes ?: \Input::all();
		$this->update 		= $update ? true : false;
		$this->customRules 	= $customRules ?: null;
	}

	public function passes() {
		if($this->update)
		{
			$validation = \Validator::make($this->attributes, static::$updateRules, static::$customMessages);
		}
		else
		{
			$validation = \Validator::make($this->attributes, static::$rules, static::$customMessages);
		}

		if($this->customRules)
		{
			$validation = \Validator::make($this->attributes, $this->customRules, static::$customMessages);
		}

		if($validation->passes()) return true;
		$this->errors = $validation->messages();
		return false;
	}

}