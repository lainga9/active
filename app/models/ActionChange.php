<?php

class ActionChange extends \Eloquent {
	protected $guarded = [];

	public function ActionObject()
	{
		return $this->belongsTo('ActionObject');
	}
}