@if( $activity->isCoverable() )
	@if( Auth::user()->appliedToCover($activity->id) )
		@if( Auth::user()->isCovering($activity) )
			<a href="#" class="btn btn-lg btn-primary" disabled>Selected to cover</a>
		@else
			<a href="#" class="btn btn-lg btn-primary" disabled>Applied to cover</a>
		@endif
	@else
		{{ Form::open(['route' => ['activity.applyToCover', $activity->id]]) }}
			<button type="submit" class="btn btn-lg btn-primary">Apply to cover</button>
		{{ Form::close() }}
	@endif
@endif