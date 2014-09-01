<?php

class ActionObject extends \Eloquent {
	protected $guarded = [];

	public function ActionChange()
	{
		return $this->hasOne('ActionChange');
	}

	public function Action()
	{
		return $this->belongsTo('Action');
	}
}