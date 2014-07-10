@section('title', 'Activities')

@section('content')
		
	@if( !$activities->isEmpty() )

		<div id="activities">

			@foreach($activities as $activity)

				@include('_partials.client.activity', ['activity' => $activity])

				<hr>

			@endforeach

		</div>

	@else

		<div class="alert alert-info">
			No Activities
		</div>

	@endif

@stop

@section('sidebar')

	@include('_partials.search.advanced')
	
@stop

@section('scripts')

	{{ HTML::script('js/search.js') }}

@stop