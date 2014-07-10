<?php

class FeedbackValue extends \Eloquent {
	protected $guarded = [];

	public function item()
	{
		return $this->belongsTo('FeedbackItem', 'feedback_item_id');
	}
}