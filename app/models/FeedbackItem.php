<?php

class FeedbackItem extends \Eloquent {
	protected $guarded = [];

	public function feedback()
	{
		return $this->belongsTo('Feedback');
	}
}