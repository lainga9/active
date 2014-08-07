@section('title', 'Welcome ' . Auth::user()->first_name)

@section('content')

	<h3>Welcome</h3>

	<hr>

	<p>This is your Activity Stream, where you can view the latest activities in you area.</p>

	<p>We have added some activities to get you started. To search for activities you are most interested in, use the search box to the left.</p>

	<p>You can add your favourite classes, venues, instructors &amp; activities by clicking on the heart icon next to their name and we will save them for you. You can view all your favourites by clicking on the favourites button above.</p>

	<p><em>Now lets get active!</em></p>	

	@if( !$activities->isEmpty() )

		@include('_partials.client.activities', compact('activities'))

	@else

		<div class="alert alert-info">
			No Activities
		</div>

	@endif

@stop

@section('sidebar')

	<ul class="nav nav-pills nav-stacked">
		<li><a href="{{ URL::route('dashboard') }}">Home</a></li>
		<li><a href="{{ URL::route('favourites') }}">Favourites</a></li>
	</ul>
	<hr>

	@include('_partials.search.basic')

@stop