@section('title', 'Favourite Activities')

@section('content')

	@if( count($activities) )

		@foreach( $activities as $activity )

			@include('_partials.client.activity-excerpt', ['activity' => $activity])

			<hr>

		@endforeach

	@else

		<div class="alert alert-info">
			You have not yet added any favourites!
		</div>

	@endif

@stop