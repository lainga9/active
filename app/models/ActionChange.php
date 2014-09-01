<?php

class ActionChange extends \Eloquent {
	protected $guarded = [];

	public function ActionObject()
	{
		return $this->belongsTo('ActionObject');
	}

	public function User()
	{
		return $this->belongsTo('User', 'actor_id');
	}
}