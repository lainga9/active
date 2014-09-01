@if( !$user->stream()->isEmpty() )

	@foreach( $user->stream() as $action )

		@include('_partials.elements.action', compact('action'))

	@endforeach

@endif