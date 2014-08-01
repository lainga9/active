<?php

class Credit extends \Eloquent {

	protected $guarded = [];

	public function Client()
	{
		return $this->belongsTo('Client');
	}

	public function Activity()
	{
		return $this->belongsTo('Activity');
	}
}