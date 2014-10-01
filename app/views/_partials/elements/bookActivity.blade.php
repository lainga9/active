@if( $activity->isFull() )
	@include('_partials.elements.fullActivity')
@elseif( $activity->isClosed() )
	@include('_partials.elements.closedActivity')
@elseif( $activity->isCancelled() )
	@include('_partials.elements.cancelledActivity')
@elseif( $activity->isAttending() )
	@include('_partials.elements.attendingActivity')
@elseif( $activity->hasPassed() )
	@include('_partials.elements.passedActivity')
@else
	<a href="{{ URL::route('activity.pay', $activity->id) }}" class="btn btn-large btn-success">Book Now</a>
@endif