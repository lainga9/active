@section('title', 'Activities you are attending')

@section('content')

	<h3>Welcome {{ Auth::user()->first_name }}, this is your activity list</h3>

	<h4>These are all of the classes you are booked into</h4>

	<hr>
		
	@if( !$activities->isEmpty() )

		<h3>All Activities</h3>

		@foreach($activities as $activity)

			<!-- <h4><a href="{{ URL::route('activities.show', $activity->id) }}" class="text-success">{{ $activity->name }}</a></h4>
			<p>{{ $activity->time_from }} - {{ $activity->time_until }}</p>
			<p>{{ date('l', strtotime($activity->date)) }} {{ $activity->date }}</p>
			<p>{{ $activity->street_address }}</p>
			<p>{{ $activity->town }}, {{ $activity->postcode }}</p>

			<hr /> -->

			@include('_partials.client.activity', compact('activity'))

		@endforeach

		<hr />

		<h3>Timetable</h3>

		@include('_partials.elements.timetable', ['activities' => Auth::user()->makeTimetable()])

	@else

		<div class="alert alert-info">
			You are not attending any activities!
		</div>

	@endif

@stop