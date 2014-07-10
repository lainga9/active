{{ Form::open(
	['route' => 
		['activity.book', $activity->id]
	] ) }}

	{{ Form::submit('Book Class', ['class' => 'btn btn-success btn-lg']) }}

{{ Form::close() }}