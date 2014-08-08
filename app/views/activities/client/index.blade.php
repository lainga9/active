@section('title', 'Activities')

@section('content')
		
	@if( !$activities->isEmpty() )

		{{ Form::open(['route' => 'user.removeFavourites']) }}
			<button type="submit" class="btn btn-danger btn-sm">Remove All Favourites</button>
		{{ Form::close() }}

		@include('_partials.client.activities', compact('activities'))

	@else

		<div class="alert alert-info">
			No Activities
		</div>

	@endif

@stop

@section('sidebar')

	@include('_partials.search.basic')
	
@stop