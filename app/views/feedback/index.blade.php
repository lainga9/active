@section('content')

	@if( !$feedback->isEmpty() )

		@foreach( $feedback as $item )

			@if( $values = $item->values )

				<div>Left on {{ $item->created_at }} for {{ $item->activity->name }}</div>

				<ul>

					@foreach( $values as $value )

						<li><strong>{{ $value->item->name }}</strong> : {{ $value->value }}</li>

					@endforeach

				</ul>

			@endif

			<hr>

		@endforeach

	@else

		<div class="alert alert-info">You currently do not have any feedback</div>

	@endif

@stop