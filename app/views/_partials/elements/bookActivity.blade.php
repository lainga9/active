@if( $activity->isAttending() )
	@include('_partials.elements.attendingActivity')
@elseif( $activity->isFull() )
	@include('_partials.elements.fullActivity')
@elseif( $activity->isClosed() )
	@include('_partials.elements.closedActivity')
@else
	<a href="{{ URL::route('activities.show', $activity->id) }}" class="btn btn-lg btn-success">Book Now</a>
@endif