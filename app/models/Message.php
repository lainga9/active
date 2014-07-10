<?php

class Message extends \Eloquent {
	protected $guarded = [];

	public function Sender()
	{
		return $this->belongsTo('User');
	}

	public function Recipient()
	{
		return $this->belongsTo('User');
	}

	public function Children()
	{
		return $this->hasMany('Message', 'thread_id')->with('sender')->with('recipient');
	}

	// Returns top level messages i.e. the ones to display in the panel on the left
	public function scopeThreads($query, $user)
	{
		return $query->with('sender')
						->with('recipient')
						->whereThreadId(0)
						->where(function($query) use ($user) {
							$query->whereSenderId($user->id)
									->orWhere('recipient_id', '=', $user->id);
						});
	}

	public function scopeThread($query, $id)
	{
		return $query->with('sender')
						->with('recipient')
						->where('thread_id', '=', $id)
						->orWhere('id', '=', $id);
	}
}