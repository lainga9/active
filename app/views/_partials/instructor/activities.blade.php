<h4>All Activities</h4>

@if( !$activities->isEmpty() )

	@foreach($activities as $activity)

		@include('_partials.instructor.activity', compact('activity'))

	@endforeach

@else
	
	<div class="alert alert-info">No Activities</div>

@endif