@section('title', 'Activities')

@section('content')
		
	@if( !$activities->isEmpty() )

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