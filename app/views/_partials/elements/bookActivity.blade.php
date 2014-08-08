@if( $activity->isAttending() )
	@include('_partials.elements.attendingActivity')
@elseif( $activity->isFull() )
	@include('_partials.elements.fullActivity')
@elseif( $activity->isClosed() )
	@include('_partials.elements.closedActivity')
@else
	{{ Form::open(
	['route' => 
		['activity.book', $activity->id]
	] ) }}

	{{ Form::submit('Book Now', ['class' => 'btn btn-success btn-lg']) }}

{{ Form::close() }}
@endif