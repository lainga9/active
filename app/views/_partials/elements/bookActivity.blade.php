{{ Form::open(
	['route' => 
		['activity.book', $activity->id]
	] ) }}

	{{ Form::submit('Book Now', ['class' => 'btn btn-success btn-lg']) }}

{{ Form::close() }}