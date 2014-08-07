@section('title', 'Activities')

@section('content')

	<h3>Welcome {{ Auth::user()->first_name }}</h3>

	<p>This is your activity stream, where you can view the latest activities in your area.</p>

	<p>We have added some activities to get you started. To search for activities you are most interested in, use the search box to the left.</p>

	<p>You can add your favourite classes, venues, instructors &amp; activities by clicking on the heart icon next to their name and we will save them for you. You can view all your favourites by clicking on the favourites button above. Now lets get active!</p>

	<hr />

	@include('_partials.elements.timetable', ['activities' => Auth::user()->userable->makeTimetable()])

	<hr>

	<h3>All Activities</h3>

	@if( !$activities->isEmpty() )

		@foreach( $activities as $activity )

			@include('_partials.instructor.activity', compact('activity'))

		@endforeach

	@endif

@stop

@section('scripts')

	{{ HTML::script('js/timetable.js') }}

@stop