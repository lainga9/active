<?php

class ActionObject extends \Eloquent {
	protected $guarded = [];

	public function ActionChange()
	{
		return $this->hasOne('ActionChange');
	}
}