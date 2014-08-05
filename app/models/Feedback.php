<?php

class Feedback extends \Eloquent {
	protected $guarded = [];

	protected $table = 'feedback';

	public function activity()
	{
		return $this->belongsTo('Activity');
	}

	public function values()
    {
        return $this->hasMany('FeedbackValue');
    }

    public function scopeOwn($query)
    {
    	return $query->whereInstructorId(Auth::user()->id);
    }

    public static function getAverage($user)
    {
    	$feedback = $user->feedback;

    	if( $feedback->isEmpty() ) return null;

    	$ratings = [];

    	foreach( $feedback as $item )
    	{
    		if( $item->values )
    		{
    			foreach( $item->values as $value )
    			{
    				$ratings[] = $value->value;
    			}
    		}
    	}

    	if( count($ratings) )
    	{
    		return (float) array_sum($ratings)/count($ratings);
    	}

    	return null;
    }

    public static function store(Feedback $feedbackObj, FeedbackValue $feedbackValueObj, $activity, $instructor, $client, $input)
    {
    	$feedback = $feedbackObj->create([
    		'activity_id' 	=> $activity->id,
    		'client_id'		=> $client->id,
    		'instructor_id' => $instructor->id
    	]);

    	unset($input['_token']);
    	unset($input['activity_id']);

    	foreach( $input as $id => $value )
		{
			$feedbackValue = $feedbackValueObj->create([
				'feedback_item_id' 	=> $id,
				'value' 			=> $value,
				'feedback_id'		=> $feedback->id
			]);
		}

		return $feedback;
    }

}